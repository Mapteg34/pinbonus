<?php

namespace App\Http\Controllers;

use App\Http\Requests\VKCodeRequest;
use App\Services\VkApiService;
use App\Services\VkOauthService;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth')->only(['user', 'logout']);
        $this->middleware('jwt.refresh')->only('refresh');
    }

    /**
     * @param VKCodeRequest $request
     * @param JWTAuth $auth
     * @param VkOauthService $oauthApi
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function login(VKCodeRequest $request, JWTAuth $auth, VkOauthService $oauthApi)
    {
        // TODO: refactor
        $result = $oauthApi->access_token($request->code);

        if (empty($result) || empty($result->access_token) || empty($result->user_id)) {
            return response()->json(['error' => 'VK Unauthorized'], 401);
        }

        $api     = new VkApiService($result->access_token);
        $profile = $api->usersGet(
            [$result->user_id],
            ['id', 'first_name', 'photo_id', 'photo_50']
        )->get($result->user_id);

        if (empty($profile)) {
            return response()->json(['error' => 'VK profile Unauthorized'], 401);
        }

        $user = User::find($result->user_id);

        if (!$user) {
            $user = new User();
        }

        $user->name         = $profile->first_name;
        $user->photo        = $profile->photo_50;
        $user->access_token = $result->access_token;
        $user->saveOrFail();
        $user->refresh();

        if (!$token = $auth->fromSubject($user)) {
            return response()->json(['error' => 'JWT unauthorized'], 401);
        }

        return response([
            'status' => 'success'
        ])->header('Authorization', $token);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        return response([
            'status' => 'success',
            'data'   => $request->user()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }

    /**
     * @param JWTAuth $auth
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout(JWTAuth $auth)
    {
        $user = request()->user();
        $auth->invalidate();

        $user->access_token = null;
        $user->save();

        return response([
            'status' => 'success',
        ], 200);
    }
}
