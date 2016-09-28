<?php

namespace Gentor\ActiveCampaign;


use Illuminate\Support\ServiceProvider;

/**
 * Class ActiveCampaignServiceProvider
 *
 * @package Gentor\ActiveCampaign
 */
class ActiveCampaignServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('activecampaign', function ($app) {
            return new ActiveCampaignService($app['config']['activecampaign']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['activecampaign'];
    }
    
}