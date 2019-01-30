<?php

namespace App\Http\Controllers;

use App\Repositories\AdsRepository;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;

class AdsController extends Controller
{

    /**
     * AdsController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * @param int $accountId
     * @param int $campaignId
     * @param AdsRepository $adsRep
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(int $accountId, int $campaignId, AdsRepository $adsRep)
    {
        return response([
            'status' => 'success',
            'ads'    => $adsRep->getAll($accountId, $campaignId),
        ]);
    }

    /**
     * @param int $accountId
     * @param int $campaignId
     * @param int $adId
     * @param Request $request
     * @param AdsRepository $adsRep
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(
        /** @noinspection PhpUnusedParameterInspection */
        int $accountId,
        int $campaignId,
        int $adId,
        Request $request,
        AdsRepository $adsRep
    )
    {
        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make([
            'accountId'  => $accountId,
            'campaignId' => $campaignId,
            'adId'       => $adId,
            'desc'       => $request->get('desc'),
        ], []);
        $validator->setRules([
            'accountId'  => [
                'required',
                'integer',
            ],
            'campaignId' => [
                'required',
                'integer',
            ],
            'adId'       => [
                'required',
                'integer',
            ],
            'desc'       => [
                'required',
                'string',
                'max:100',
                'bail',
                function(
                    /** @noinspection PhpUnusedParameterInspection */
                    $attribute,
                    $value,
                    $fail
                ) use ($adsRep, $validator, $accountId, $campaignId, $adId) {
                    if (!$validator->messages()->isEmpty()) {
                        return;
                    }

                    $ad = $adsRep->getAll($accountId, $campaignId, $adId)->get($adId);

                    if (empty($ad)) {
                        $fail('Объявление не найдено');
                    }
                },
            ]
        ]);
        $adsRep->saveDesc($accountId, $campaignId, $adId, $request->get('desc'));

        $ad = $adsRep->getAll($accountId, $campaignId)->get($adId);

        return response([
            'status' => 'success',
            'ad'     => $ad,
        ]);
    }

    /**
     * @param int $accountId
     * @param int $campaignId
     * @param int $adId
     * @param AdsRepository $adsRep
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(
        int $accountId,
        int $campaignId,
        int $adId,
        AdsRepository $adsRep
    )
    {
        $adsRep->remove($accountId, $campaignId, $adId);

        return response([
            'status' => 'success',
            'ads'    => $adsRep->getAll($accountId, $campaignId),
        ]);
    }
}
