<?php

namespace App\Repositories;

use App\Services\VkApiService;
use Illuminate\Support\Facades\Cache;

class AccountsRepository
{
    /**
     * @var VkApiService
     */
    private $api;

    /**
     * AccountsRepository constructor.
     *
     * @param VkApiService $api
     */
    public function __construct(VkApiService $api)
    {
        $this->api = $api;
    }

    /**
     * @param bool $useCache
     *
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function getAll(bool $useCache = true)
    {
        $cacheKey = 'accounts'.auth()->id();
        $has      = Cache::has($cacheKey);

        if (!$useCache || !$has) {
            $accounts = $this->api->adsGetAccounts();
            Cache::forever($cacheKey, $accounts);
        } else {
            $accounts = Cache::get($cacheKey);
        }

        return $accounts;
    }
}
