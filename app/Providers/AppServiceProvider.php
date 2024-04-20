<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Foundation\AliasLoader;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Loader Alias
        $loader = AliasLoader::getInstance();
        // SANCTUM CUSTOM PERSONAL-ACCESS-TOKEN
        $loader->alias(\Laravel\Sanctum\PersonalAccessToken::class, \App\Models\Sanctum\PersonalAccessToken::class);
        // Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Response::macro('error', function ($textError, $status = 404) {
            return response()->json([
                'status' => "error",
                'message' => $textError
            ], $status);
        });

        Response::macro('success', function ($status = 200) {
            return response()->json([
                'status' => "OK",
            ], $status);
        });
    }
}
