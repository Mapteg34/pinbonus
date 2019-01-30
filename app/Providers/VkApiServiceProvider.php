<?php

namespace App\Providers;

use App\Services\VkApiService;
use App\Services\VkOauthService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class VkApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(VkOauthService::class, function() {
            return new VkOauthService(
                config('app.url').'/#/login',
                config('pinbonus.vk_app_id'),
                config('pinbonus.vk_secret')
            );
        });
        $this->app->bind(VkApiService::class, function() {
            /** @var User $user */
            $user = Auth::user();
            if (empty($user)) {
                throw new \Exception('only authorized can work with api');
            }

            return new VkApiService(
                $user->access_token
            );
        });
    }
}
