<?php

namespace App\Services;

use GuzzleHttp\Client;

class VkApiService
{

    /**
     * @var Client
     */
    private $client;
    /**
     * @var string
     */
    private $accessToken;
    /**
     * @var string
     */
    private $version = '5.92';

    /**
     * VkApiService constructor.
     *
     * @param $accessToken
     */
    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->client      = new Client();
    }

    /**
     * @param $method
     * @param array $params
     *
     * @return mixed
     * @throws \Exception
     */
    private function post($method, $params = [])
    {
        $url = 'https://api.vk.com/method/'.$method.'?'.http_build_query([
                'access_token' => $this->accessToken,
                'v'            => $this->version
            ]);

        $res = json_decode($this->client->post($url, [
            'form_params' => $params,
        ])->getBody());

        if (!empty($res->error)) {
            throw new \Exception('Vk error: '.json_encode($res->error));
        }

        return $res->response;
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function adsGetAccounts()
    {
        return collect(
            $this->post('ads.getAccounts')
        )->keyBy('account_id');
    }

    /**
     * @param int $accountId
     *
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function adsGetCampaigns(int $accountId)
    {
        return collect(
            $this->post('ads.getCampaigns', [
                'account_id' => $accountId
            ])
        )->keyBy('id');
    }

    /**
     * @param int $accountId
     * @param null $campaignIds
     *
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function adsGetAds(int $accountId, $campaignIds = null)
    {
        return collect(
            $this->post('ads.getAds', [
                'account_id'   => $accountId,
                'campaign_ids' => json_encode($campaignIds),
            ])
        )->keyBy('id');
    }
}
