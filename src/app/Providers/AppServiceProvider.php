<?php

namespace App\Providers;

use Fluffici\SDK\AuthSDK;
use Illuminate\Support\ServiceProvider;
use Ramsey\Uuid\Uuid;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app()->singleton('authSDK', function() {
            $authSDK = new AuthSDK();
            $authSDK->setGrantType('user_direct');
            $authSDK->setClientId(env('AUTH_CLIENT_ID'));
            $authSDK->setClientSecret(env('AUTH_CLIENT_SECRET'));
            $authSDK->setRedirectUri(env('AUTH_REDIRECT_URI'));
            $authSDK->setState(Uuid::uuid4()->toString());
            $authSDK->setScope(env('AUTH_CLIENT_SCOPE'));
            $this->authSDK = $authSDK->build();

            return $this->authSDK;
        });
    }
}
