<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:api')->only([
            'login',
            'register',
        ]);
        $this->middleware('jwt.auth')->only(['user', 'logout']);
        $this->middleware('jwt.refresh')->only('refresh');
    }

    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function register(RegisterRequest $request)
    {
        $user = $request->makeUser();
        $user->saveOrFail();

        return response([
            'status' => 'success',
            'data'   => $user,
        ], 200);
    }

    public function login(LoginFormRequest $request, JWTAuth $auth)
    {
        $credentials = $request->validated();

        if (!$token = $auth->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
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
        $auth->invalidate();

        return response([
            'status' => 'success',
            'msg'    => 'Successfully logged out'
        ], 200);
    }
}
