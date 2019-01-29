<?php

namespace App\Http\Controllers;

use App\Http\Requests\VKCodeRequest;
use App\Http\Requests\VKUpdateTokenRequest;
use App\Services\VkOauthService;
use App\User;

class VkTokenController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth')->only(['updateToken']);
    }

    public function transmitCode(VKCodeRequest $request)
    {
        return view('spa', ['vkCode' => $request->code]);
    }

    /**
     * @param VKUpdateTokenRequest $request
     * @param VkOauthService $api
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function updateToken(VKUpdateTokenRequest $request, VkOauthService $api)
    {
        $result = $api->access_token($request->code);

        if (empty($result) || empty($result->access_token) || empty($result->user_id)) {
            throw new \Exception('Failed update token');
        }

        /** @var User $user */
        $user           = $request->user();
        $user->vk_token = $result->access_token;
        $user->vk_id    = $result->user_id;
        $user->saveOrFail();
        $user->refresh();

        return response([
            'status' => 'success',
            'user'   => $user
        ]);
    }
}
