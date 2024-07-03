<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class GetNet extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'getnet';
    }
}
