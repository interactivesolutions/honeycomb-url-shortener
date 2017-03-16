<?php

namespace interactivesolutions\honeycomburlshortener\app\providers;

use Illuminate\Support\ServiceProvider;

class HCURLShortenerServiceProvider extends ServiceProvider
{
    protected $homeDirectory = __DIR__;

    protected $commands = [];

    protected $namespace = 'interactivesolutions\honeycomburlshortener\app\http\controllers';
}


