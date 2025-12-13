<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Swift_Message;

class GmailService
{


    public static function sendEmail($to, $subject, $body)
    {
        $client = new Client();  //This client handles: Authentication,Token management,API requests
        $client->setAuthConfig(storage_path('app/google/credentials.json'));  // Load OAuth Credentials: Client ID , Client Secret
        $client->setAccessType('offline'); // Enables refresh tokens, 
        $client->setScopes(['https://www.googleapis.com/auth/gmail.send']); // Grants permission to : Send emails only

        $client->setAccessToken(json_decode(file_get_contents(storage_path('app/google/token.json')), true));

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

            file_put_contents(
                storage_path('app/google/token.json'),
                json_encode($client->getAccessToken())
            );
        }

        $service = new Gmail($client); // This service is used to: Send messages , Read inbox

        // -----------------------------
        // Build MIME email manually
        // -----------------------------
        $rawMessageString =
            "To: <$to>\r\n" .
            "Subject: $subject\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=utf-8\r\n\r\n" .
            $body;

        // Encode to Base64URL - Gmail API requires Base64 URL-safe encoding
        $rawMessage = rtrim(strtr(base64_encode($rawMessageString), '+/', '-_'), '=');  

        // Send Email -  Gmail Message Object : Wraps the encoded email into a Gmail-compatible object
        $message = new Gmail\Message();
        $message->setRaw($rawMessage);

        return $service->users_messages->send('me', $message); // 'me' → authenticated Gmail user
    }
}
