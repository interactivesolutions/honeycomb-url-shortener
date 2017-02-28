<?php

namespace interactivesolutions\honeycomburlshortener\app\models;

use interactivesolutions\honeycombcore\models\HCUuidModel;

class HCShortURL extends HCUuidModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hc_short_url';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'url', 'short_url_key', 'description', 'clicks'];

}
