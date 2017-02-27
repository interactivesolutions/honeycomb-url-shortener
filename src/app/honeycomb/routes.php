<?php

//packages/interactivesolutions/honeycomb-url-shortener/src/app/routes/routes.url.shortener.php

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth']], function ()
{
    Route::get('url-shortener', ['as' => 'admin.url.shortener', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@adminView']);

    Route::group(['prefix' => 'api'], function ()
    {
        Route::get('url-shortener', ['as' => 'admin.api.url.shortener', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@listData']);
        Route::get('url-shortener/search', ['as' => 'admin.api.url.shortener.search', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@search']);
        Route::get('url-shortener/{id}', ['as' => 'admin.api.url.shortener.single', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_list'], 'uses' => 'HCURLShortenerController@getSingleRecord']);
        Route::post('url-shortener/{id}/duplicate', ['as' => 'admin.api.url.shortener.duplicate', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@duplicate']);
        Route::post('url-shortener/restore', ['as' => 'admin.api.url.shortener.restore', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@restore']);
        Route::post('url-shortener/merge', ['as' => 'admin.api.url.shortener.merge', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@merge']);
        Route::post('url-shortener', ['middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_create'], 'uses' => 'HCURLShortenerController@create']);
        Route::put('url-shortener/{id}', ['middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_update'], 'uses' => 'HCURLShortenerController@update']);
        Route::delete('url-shortener/{id}', ['middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_delete'], 'uses' => 'HCURLShortenerController@delete']);
        Route::delete('url-shortener', ['middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_delete'], 'uses' => 'HCURLShortenerController@delete']);
        Route::delete('url-shortener/{id}/force', ['as' => 'admin.api.url.shortener.force', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_force_delete'], 'uses' => 'HCURLShortenerController@forceDelete']);
        Route::delete('url-shortener/force', ['as' => 'admin.api.url.shortener.force.multi', 'middleware' => ['acl:interactivesolutions_honeycomb_url_shortener_url_shortener_force_delete'], 'uses' => 'HCURLShortenerController@forceDelete']);
    });
});

Route::get('r/{shortKeyURL}', ['as' => 'url.shortener', 'uses' => 'HCURLShortenerController@redirect']);

Route::get('/', function ()
{
    echo generateHCShortURL('https://www.google.lt/search?q=http+slug+icon&biw=1920&bih=950&source=lnms&tbm=isch&sa=X&ved=0ahUKEwjZuv_Z86_SAhWBHpoKHb_iDvQQ_AUIBigB');
});

