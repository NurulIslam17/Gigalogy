<?php

namespace App\Console\Commands;

use Google\Client;
use Illuminate\Console\Command;

class GenerateGmailToken extends Command
{
    protected $signature = 'gmail:token';
    protected $description = 'Generate Gmail API OAuth Token';
    /*
        It will ask you to open a URL in your browser and enter the authorization code.
        Then it will store the token in a file.
    */
    public function handle()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google/credentials.json'));
        $client->setScopes(['https://www.googleapis.com/auth/gmail.send']);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        $authUrl = $client->createAuthUrl();
        $this->info("Open this URL in browser:\n$authUrl");

        $code = $this->ask('Enter the authorization code here');

        $token = $client->fetchAccessTokenWithAuthCode($code);

        file_put_contents(storage_path('app/google/token.json'), json_encode($token));

        $this->info('Token stored successfully!');
    }
}
