<?php

namespace App\Providers;

use App\Helpers\DateHelper;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->fungsiHelper();
        $this->app->singleton(DateHelper::class, function () {
            return new DateHelper();
        });        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }

    protected function fungsiHelper()
    {
        foreach (glob(__DIR__.'/../Helpers/*.php') as $namafile) {
            require_once $namafile;
        }
    }
}
