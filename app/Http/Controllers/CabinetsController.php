<?php

namespace App\Http\Controllers;

use App\Services\VkApiService;

class CabinetsController extends Controller
{

    /**
     * CabinetsController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * @param VkApiService $api
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index(VkApiService $api)
    {
        /**
         * по хорошему кабинеты должны храниться в базе и доставаться из нее через кеш
         * а уже периодически (или по запросу) синхронизироваться с вк.
         * но в рамках задачи этого нет, поэтому
         */

        try {
            return response([
                'status'   => 'success',
                'cabinets' => $api->adsGetAccounts(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param $accountId
     * @param VkApiService $api
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function showCabinet($accountId, VkApiService $api)
    {
        /**
         * по хорошему кабинеты должны храниться в базе и доставаться из нее через кеш
         * а уже периодически (или по запросу) синхронизироваться с вк.
         * но в рамках задачи этого нет, поэтому
         */

        $cabinet = $api->adsGetAccounts()->get($accountId);

        if (empty($cabinet)) {
            abort(404);
        }

        $campaigns = $api->adsGetCampaigns($accountId);

        return response([
            'status'    => 'success',
            'cabinet'   => $cabinet,
            'campaigns' => $campaigns,
        ]);

    }

    /**
     * @param $accountId
     * @param $campaignId
     * @param VkApiService $api
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function showCampaign($accountId, $campaignId, VkApiService $api)
    {
        /**
         * по хорошему кабинеты должны храниться в базе и доставаться из нее через кеш
         * а уже периодически (или по запросу) синхронизироваться с вк.
         * но в рамках задачи этого нет, поэтому
         */

        $cabinet = $api->adsGetAccounts()->get($accountId);

        if (empty($cabinet)) {
            abort(404);
        }

        $campaign = $api->adsGetCampaigns($accountId)->get($campaignId);

        if (empty($campaign)) {
            abort(404);
        }

        $ads = $api->adsGetAds($accountId, [$campaignId]);

        return response([
            'status'   => 'success',
            'cabinet' => $cabinet,
            'campaign' => $campaign,
            'ads' => $ads,
        ]);

    }
}
