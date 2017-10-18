<?php

Route::group(['prefix' => 'api', 'middleware' => ['auth-apps']], function() {
    Route::group(['prefix' => 'v1/url-shortener'], function() {
        Route::get('/', [
            'as' => 'api.v1.url.shortener',
            'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_list'],
            'uses' => 'HCURLShortenerController@apiIndexPaginate',
        ]);
        Route::post('/', [
            'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_create'],
            'uses' => 'HCURLShortenerController@apiStore',
        ]);
        Route::delete('/', [
            'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_delete'],
            'uses' => 'HCURLShortenerController@apiDestroy',
        ]);

        Route::group(['prefix' => 'list'], function() {
            Route::get('/', [
                'as' => 'api.v1.url.shortener.list',
                'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_list'],
                'uses' => 'HCURLShortenerController@apiIndex',
            ]);
            Route::get('{timestamp}', [
                'as' => 'api.v1.url.shortener.list.update',
                'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_list'],
                'uses' => 'HCURLShortenerController@apiIndexSync',
            ]);
        });

        Route::post('merge', [
            'as' => 'api.v1.url.shortener.merge',
            'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_update'],
            'uses' => 'HCURLShortenerController@apiMerge',
        ]);
        Route::post('restore', [
            'as' => 'api.v1.url.shortener.restore',
            'middleware' => [
                'acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_create',
                'acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_update',
            ],
            'uses' => 'HCURLShortenerController@apiRestore',
        ]);
        Route::delete('force', [
            'as' => 'api.v1.url.shortener.force.multi',
            'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_force_delete'],
            'uses' => 'HCURLShortenerController@apiForceDelete',
        ]);

        Route::group(['prefix' => 'list'], function() {
            Route::get('/', [
                'as' => 'api.v1.url.shortener.single',
                'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_list'],
                'uses' => 'HCURLShortenerController@apiShow',
            ]);
            Route::put('/', [
                'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_update'],
                'uses' => 'HCURLShortenerController@apiUpdate',
            ]);
            Route::delete('/', [
                'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_delete'],
                'uses' => 'HCURLShortenerController@apiDestroy',
            ]);

            Route::post('strict', [
                'as' => 'api.v1.url.shortener.update.strict',
                'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_update'],
                'uses' => 'HCURLShortenerController@apiUpdateStrict',
            ]);
            Route::post('duplicate', [
                'as' => 'api.v1.url.shortener.duplicate',
                'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_create'],
                'uses' => 'HCURLShortenerController@apiDuplicate',
            ]);
            Route::delete('force', [
                'as' => 'api.v1.url.shortener.force',
                'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_force_delete'],
                'uses' => 'HCURLShortenerController@apiForceDelete',
            ]);
        });
    });
});
