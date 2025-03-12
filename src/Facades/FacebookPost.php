<?php

namespace Kalimeromk\FacebookPost\Facades;

use Illuminate\Support\Facades\Facade;
use Kalimeromk\FacebookPost\Services\FacebookPostService;

class FacebookPost extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FacebookPostService::class;
    }
}