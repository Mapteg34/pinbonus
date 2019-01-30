<?php

namespace App\Http\Controllers;

use App\Repositories\AccountsRepository;

class AccountsController extends Controller
{

    /**
     * AccountsController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * @param AccountsRepository $accountsRep
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(AccountsRepository $accountsRep)
    {
        return response([
            'status'   => 'success',
            'accounts' => $accountsRep->getAll(),
        ]);
    }

    /**
     * @param int $accountId
     * @param AccountsRepository $accountsRep
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function show(int $accountId, AccountsRepository $accountsRep)
    {
        $account = $accountsRep->getAll()->get($accountId);

        if (empty($account)) {
            abort(404);
        }

        return response([
            'status'  => 'success',
            'account' => $account,
        ]);
    }
}
