<?php

Route::group(['prefix' => config('hc.admin_url'), 'middleware' => ['web', 'auth']], function ()
{
    Route::get('url-shortener', ['as' => 'admin.url.shortener', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@adminIndex']);

    Route::group(['prefix' => 'api/url-shortener'], function ()
    {
        Route::get('/', ['as' => 'admin.api.url.shortener', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_create'], 'uses' => 'HCURLShortenerController@apiStore']);
        Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_delete'], 'uses' => 'HCURLShortenerController@apiDestroy']);

        Route::post('restore', ['as' => 'admin.api.url.shortener.restore', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@apiRestore']);
        Route::post('merge', ['as' => 'admin.api.url.shortener.merge', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_create', 'acl:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@apiMerge']);
        Route::delete('force', ['as' => 'admin.api.url.shortener.force.multi', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_force_delete'], 'uses' => 'HCURLShortenerController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'admin.api.url.shortener.single', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@apiShow']);
            Route::put('/', ['middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_delete'], 'uses' => 'HCURLShortenerController@apiDestroy']);

            Route::post('strict', ['as' => 'admin.api.url.shortener.update.strict', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'admin.api.url.shortener.duplicate', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_create'], 'uses' => 'HCURLShortenerController@apiDuplicate']);
            Route::delete('force', ['as' => 'admin.api.url.shortener.force', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_force_delete'], 'uses' => 'HCURLShortenerController@apiForceDelete']);
        });
    });
});

