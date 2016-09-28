<?php

namespace Gentor\ActiveCampaign\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Gentor\ActiveCampaign\ActiveCampaignService
 */
class ActiveCampaign extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'activecampaign';
    }
}
