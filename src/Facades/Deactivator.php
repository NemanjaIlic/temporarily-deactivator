<?php

namespace NemanjaIlic\ModelDeactivator\Facades;

use Illuminate\Support\Facades\Facade;

class Deactivator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'deactivator';
    }
}