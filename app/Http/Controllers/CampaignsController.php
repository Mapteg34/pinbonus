<?php

namespace App\Http\Controllers;

use App\Repositories\AccountsRepository;
use App\Repositories\CampaignsRepository;

class CampaignsController extends Controller
{

    /**
     * CampaignsController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }


    /**
     * @param int $accountId
     * @param CampaignsRepository $campaignsRep
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(int $accountId, CampaignsRepository $campaignsRep)
    {
        return response([
            'status'    => 'success',
            'campaigns' => $campaignsRep->getAll($accountId),
        ]);
    }

    /**
     * @param int $accountId
     * @param int $campaignId
     * @param CampaignsRepository $campaignsRep
     * @param AccountsRepository $accountsRep
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function show(int $accountId, int $campaignId, CampaignsRepository $campaignsRep, AccountsRepository $accountsRep)
    {
        $account = $accountsRep->getAll()->get($accountId);

        if (empty($account)) {
            abort(404, 'Account not found');
        }

        $campaign = $campaignsRep->getAll($accountId)->get($campaignId);

        if (empty($campaign)) {
            abort(404, 'Campaign not found');
        }

        $campaign = (object)array_merge(
            ['cabinet_name' => $account->account_name],
            (array)$campaign
        );

        return response([
            'status'   => 'success',
            'campaign' => $campaign,
        ]);
    }
}
