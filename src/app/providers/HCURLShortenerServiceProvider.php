<?php

namespace interactivesolutions\honeycomburlshortener\app\providers;


use InteractiveSolutions\HoneycombCore\Providers\HCBaseServiceProvider;

class HCURLShortenerServiceProvider extends HCBaseServiceProvider
{
    protected $homeDirectory = __DIR__;

    protected $commands = [];

    protected $namespace = 'interactivesolutions\honeycomburlshortener\app\http\controllers';

    public $serviceProviderNameSpace = 'HCURLShortener';

}


