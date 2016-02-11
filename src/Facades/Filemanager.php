<?php

namespace Simexis\Filemanager\Facades;

use Illuminate\Support\Facades\Facade;

class Filemanager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
{
    return 'filemanager';
}

}