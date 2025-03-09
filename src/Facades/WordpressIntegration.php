<?php

namespace Luinuxscl\WordpressIntegration\Facades;

use Illuminate\Support\Facades\Facade;

class WordpressIntegration extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'wordpress-integration';
    }
}
