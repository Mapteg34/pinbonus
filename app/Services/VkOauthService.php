<?php

namespace App\Services;

use GuzzleHttp\Client;

class VkOauthService
{

    private $appId;
    private $secret;
    private $client;
    private $redirectUri;

    public function __construct(string $redirectUri, string $appId, string $secret)
    {
        $this->appId       = $appId;
        $this->secret      = $secret;
        $this->redirectUri = $redirectUri;
        $this->client      = new Client();
    }

    public function access_token($code)
    {
        $response = $this->client->post('https://oauth.vk.com/access_token', [
            'form_params' => [
                'client_id'     => $this->appId,
                'client_secret' => $this->secret,
                'redirect_uri'  => $this->redirectUri,
                'code'          => $code,
            ]
        ]);

        return json_decode($response->getBody());
    }
}
