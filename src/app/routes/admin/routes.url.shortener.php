<?php

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth']], function () {
    Route::get('url-shortener', ['as' => 'admin.url.shortener', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@adminView']);

    Route::group(['prefix' => 'api/url-shortener'], function () {
        Route::get('/', ['as' => 'admin.api.url.shortener', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@listPage']);
        Route::get('list/{timestamp}', ['as' => 'admin.api.url.shortener.list.update', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@listUpdate']);
        Route::get('list', ['as' => 'admin.api.url.shortener.list', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@list']);
        Route::get('search', ['as' => 'admin.api.url.shortener.search', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@search']);
        Route::get('{id}', ['as' => 'admin.api.url.shortener.single', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@getSingleRecord']);

        Route::post('{id}/duplicate', ['as' => 'admin.api.url.shortener.duplicate', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@duplicate']);
        Route::post('restore', ['as' => 'admin.api.url.shortener.restore', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@restore']);
        Route::post('merge', ['as' => 'admin.api.url.shortener.merge', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@merge']);
        Route::post('/', ['middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_create'], 'uses' => 'HCURLShortenerController@create']);

        Route::put('{id}', ['middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@update']);

        Route::delete('{id}', ['middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_delete'], 'uses' => 'HCURLShortenerController@delete']);
        Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_delete'], 'uses' => 'HCURLShortenerController@delete']);
        Route::delete('{id}/force', ['as' => 'admin.api.url.shortener.force', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_force_delete'], 'uses' => 'HCURLShortenerController@forceDelete']);
        Route::delete('force', ['as' => 'admin.api.url.shortener.force.multi', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_force_delete'], 'uses' => 'HCURLShortenerController@forceDelete']);
    });
});

Route::get('r/{shortKeyURL}', ['as' => 'url.shortener', 'uses' => 'HCURLShortenerController@redirect']);
