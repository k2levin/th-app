<?php

Route::get('list', 'HomeController@list')->name('home.list');
Route::post('search', 'HomeController@search')->name('home.search');
