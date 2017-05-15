<?php

use interactivesolutions\honeycomburlshortener\app\models\HCShortURL;

if (!function_exists('generateHCShortURL'))
{
    /**
     * Generating short url
     *
     * @param string $url
     * @param string $description
     * @param bool $full return only short url or full db object
     * @return mixed
     */
    function generateHCShortURL (string $url, string $description = null, bool $full = false)
    {
        $unique = false;
        while (!$unique)
        {
            $shortURLKey = str_random(env('SHORT_URL_LENGTH', 5));
            $record = HCShortURL::where('short_url_key', $shortURLKey)->first();

            if (!$record)
                $unique = true;
        }

        $record = HCShortURL::create(['url' => $url, 'short_url_key' => $shortURLKey,'description' => $description ,'clicks' => 0]);

        if ($full)
            return $record;

        return route('url.shortener', [$record->short_url_key]);
    }
}