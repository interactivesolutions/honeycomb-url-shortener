<?php

Route::group(['prefix' => 'api', 'middleware' => ['auth-apps']], function () {
    Route::get('url-shortener', ['as' => 'api.v1.url.shortener', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@adminView']);

    Route::group(['prefix' => 'v1/url-shortener'], function () {
        Route::get('/', ['as' => 'api.v1.api.url.shortener', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@listPage']);
        Route::get('list/{timestamp}', ['as' => 'api.v1.api.url.shortener.list.update', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@listUpdate']);
        Route::get('list', ['as' => 'api.v1.api.url.shortener.list', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@list']);
        Route::get('search', ['as' => 'api.v1.api.url.shortener.search', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@search']);
        Route::get('{id}', ['as' => 'api.v1.api.url.shortener.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@getSingleRecord']);

        Route::post('{id}/duplicate', ['as' => 'api.v1.api.url.shortener.duplicate', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@duplicate']);
        Route::post('restore', ['as' => 'api.v1.api.url.shortener.restore', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@restore']);
        Route::post('merge', ['as' => 'api.v1.api.url.shortener.merge', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@merge']);
        Route::post('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_create'], 'uses' => 'HCURLShortenerController@create']);

        Route::put('{id}', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@update']);

        Route::delete('{id}', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_delete'], 'uses' => 'HCURLShortenerController@delete']);
        Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_delete'], 'uses' => 'HCURLShortenerController@delete']);
        Route::delete('{id}/force', ['as' => 'api.v1.api.url.shortener.force', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_force_delete'], 'uses' => 'HCURLShortenerController@forceDelete']);
        Route::delete('force', ['as' => 'api.v1.api.url.shortener.force.multi', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_url_shortener_url_shortener_force_delete'], 'uses' => 'HCURLShortenerController@forceDelete']);
    });
});

Route::get('r/{shortKeyURL}', ['as' => 'url.shortener', 'uses' => 'HCURLShortenerController@redirect']);
