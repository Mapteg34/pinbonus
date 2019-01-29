<?php

namespace App\Http\Requests;

use App\Rules\Login;
use App\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $login
 * @property string $password
 */
class LoginFormRequest extends FormRequest
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
            ],
            'password' => [
                'required',
                new Password,
            ],
        ];
    }
}
