<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      // Dao registration
      $this->app->bind('App\Contracts\Dao\User\UserDaoInterface', 'App\Dao\User\UserDao');
      $this->app->bind('App\Contracts\Dao\News\NewsDaoInterface', 'App\Dao\News\NewsDao');
      $this->app->bind('App\Contracts\Dao\PW_Resets\PW_ResetsDaoInterface', 'App\Dao\PW_Resets\PW_ResetsDao');

      // Service registration
      $this->app->bind('App\Contracts\Services\User\UserServiceInterface', 'App\Services\User\UserService');
      $this->app->bind('App\Contracts\Services\News\NewsServiceInterface', 'App\Services\News\NewsService');
      $this->app->bind('App\Contracts\Services\PW_Resets\PW_ResetsServiceInterface', 'App\Services\PW_Resets\PW_ResetsService');
    }
}
