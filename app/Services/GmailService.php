<?php

namespace App\Services;

use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Exception;
use Illuminate\Support\Facades\Log;

class GmailService
{

    protected $client;
    protected $service;
    protected $userEmail;

    public function __construct()
    {
        // Configure Google Client with credentials from env
        $client = new Google_Client();
        $client->setApplicationName(config('app.name') . ' Gmail API');
        $client->setClientId(env('GMAIL_CLIENT_ID'));
        $client->setClientSecret(env('GMAIL_CLIENT_SECRET'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // We will set the refresh token from ENV and fetch access token
        $refreshToken = env('GMAIL_REFRESH_TOKEN');
        if (!$refreshToken) {
            throw new Exception('GMAIL_REFRESH_TOKEN not configured');
        }

        $client->refreshToken($refreshToken);
        $accessToken = $client->getAccessToken();

        $client->setAccessToken($accessToken);
        // If token expired, refresh
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($refreshToken);
        }

        $this->client = $client;
        $this->service = new Google_Service_Gmail($client);
        $this->userEmail = env('GMAIL_USER'); // the "From" address
    }


    public function sendMessage(string $to, string $subject, string $htmlBody)
    {

        Log::info('Sending email to ' . $to);
        $rawMessageString = $this->buildRawMessage($to, $subject, $htmlBody);
        $message = new Google_Service_Gmail_Message();
        $message->setRaw($rawMessageString);

        try {
            return $this->service->users_messages->send($this->userEmail, $message);
        } catch (Exception $e) {
            // Log the error and rethrow or handle gracefully
            Log::error('Gmail API error: ' . $e->getMessage());
            throw $e;
        }
    }
}
