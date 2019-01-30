<?php

namespace App\Repositories;

use App\Services\VkApiService;
use Illuminate\Support\Facades\Cache;

class CampaignsRepository
{
    /**
     * @var VkApiService
     */
    private $api;

    /**
     * CampaignsRepository constructor.
     *
     * @param VkApiService $api
     */
    public function __construct(VkApiService $api)
    {
        $this->api = $api;
    }

    /**
     * @param int $accountId
     * @param bool $useCache
     *
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function getAll(int $accountId, bool $useCache = true)
    {
        $cacheKey = 'campaigns'.auth()->id().'_'.$accountId;
        $has      = Cache::has($cacheKey);

        if (!$useCache || !$has) {
            $campaigns = $this->api->adsGetCampaigns($accountId);
            Cache::forever($cacheKey, $campaigns);
        } else {
            $campaigns = Cache::get($cacheKey);
        }

        return $campaigns;
    }
}
