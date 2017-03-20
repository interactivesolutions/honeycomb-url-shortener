<?php

namespace interactivesolutions\honeycomburlshortener\app\providers;

use interactivesolutions\honeycombcore\providers\HCBaseServiceProvider;

class HCURLShortenerServiceProvider extends HCBaseServiceProvider
{
    protected $homeDirectory = __DIR__;

    protected $commands = [];

    protected $namespace = 'interactivesolutions\honeycomburlshortener\app\http\controllers';

    public $serviceProviderNameSpace = 'HCURLShortener';

}


