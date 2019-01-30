<?php

namespace App\Repositories;

use App\AdDesc;
use App\Services\VkApiService;
use Illuminate\Support\Facades\Cache;

class AdsRepository
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

    private function getCacheKey(int $accountId, int $campaignId)
    {
        return 'ads'.auth()->id().'_'.$accountId.'_'.$campaignId;
    }

    /**
     * @param int $accountId
     * @param int $campaignId
     * @param bool $useCache
     *
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function getAll(int $accountId, int $campaignId, bool $useCache = true)
    {
        $cacheKey = $this->getCacheKey($accountId, $campaignId);
        $has      = Cache::has($cacheKey);

        if (!$useCache || !$has) {
            $ads = $this->api->adsGetAds($accountId, [$campaignId]);

            $adsIds = $ads->pluck('id')->unique();

            /** @var \App\User $user */
            $user = auth()->user();

            $descs = $user->adDescs()->where(
                ['ad_id' => $adsIds]
            )->pluck('desc', 'ad_id');

            $removed = $user->removedAds()->where(
                ['ad_id' => $adsIds]
            )->pluck('ad_id');

            foreach ($ads as $adId => &$ad) {
                $ad->user_desc = $descs->has($adId) ? $descs[$adId] : '';
                $ad->removed   = in_array($adId, $removed->toArray());
            }

            Cache::forever($cacheKey, $ads);
        } else {
            $ads = Cache::get($cacheKey);
        }

        return $ads;
    }

    public function saveDesc(int $accountId, int $campaignId, int $adId, string $desc)
    {
        /** @var \App\User $user */
        $user = auth()->user();

        $model = $user->adDescs()->where(['ad_id' => $adId])->first();

        if (empty($model)) {
            $model = new AdDesc([
                'ad_id' => $adId,
            ]);
        }

        $model->desc = $desc;

        $user->adDescs()->save($model);

        Cache::forget($this->getCacheKey($accountId, $campaignId));
    }

    /**
     * @param int $accountId
     * @param int $campaignId
     * @param int $adId
     */
    public function remove(int $accountId, int $campaignId, int $adId)
    {
        /** @var \App\User $user */
        $user = auth()->user();

        $model = $user->removedAds()->where(['ad_id' => $adId])->first();

        if (empty($model)) {
            $model = $user->removedAds()->create([
                'ad_id' => $adId,
            ]);

            Cache::forget($this->getCacheKey($accountId, $campaignId));
        }
    }
}
