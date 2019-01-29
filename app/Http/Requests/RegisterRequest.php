<?php

namespace App\Http\Requests;

use App\Rules\Login;
use App\Rules\Password;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $login
 * @property string $password
 */
class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login'    => [
                'required',
                new Login,
                'bail',
                'unique:users',
            ],
            'password' => [
                'required',
                new Password,
            ],
        ];
    }

    /**
     * @return User
     */
    public function makeUser(): User
    {
        $data             = collect($this->validated())->only(['login', 'password'])->toArray();
        $data['password'] = bcrypt($data['password']);

        $user = new User($data);

        return $user;
    }
}
