<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Swift_Message;

class GmailService
{


    public static function sendEmail($to, $subject, $body)
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google/credentials.json'));
        $client->setAccessType('offline');
        $client->setScopes(['https://www.googleapis.com/auth/gmail.send']);

        $client->setAccessToken(json_decode(file_get_contents(storage_path('app/google/token.json')), true));

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

            file_put_contents(
                storage_path('app/google/token.json'),
                json_encode($client->getAccessToken())
            );
        }

        $service = new Gmail($client);

        // -----------------------------
        // Build MIME email manually
        // -----------------------------
        $rawMessageString =
            "From: Your App <yourgmail@gmail.com>\r\n" .
            "To: <$to>\r\n" .
            "Subject: $subject\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=utf-8\r\n\r\n" .
            $body;

        // Encode to Base64URL
        $rawMessage = rtrim(strtr(base64_encode($rawMessageString), '+/', '-_'), '=');

        // Send Email
        $message = new Gmail\Message();
        $message->setRaw($rawMessage);

        return $service->users_messages->send('me', $message);
    }
}
