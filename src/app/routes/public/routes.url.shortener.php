<?php

Route::get('r/{shortKeyURL}', ['as' => 'url.shortener', 'uses' => 'HCURLShortenerController@redirect']);
