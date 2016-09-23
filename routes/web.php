<?php


Route::group(['middleware' => 'auth'], function () {


	Route::get('/', 'ContactsController@index');
	Route::get('contacts', 'ContactsController@index');
	Route::post('contacts/store', 'ContactsController@store');
	Route::post('contacts/search', 'ContactsController@search');

	Route::group(['middleware' => ['auth', 'user']], function () {
		Route::get('contacts/{contact}/delete', 'ContactsController@delete');
		Route::get('contacts/{contact}', 'ContactsController@show');
		Route::patch('contacts/{contact}', 'ContactsController@update');
	});
});


Route::get('auth/github', 'Auth\GithubAuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\GithubAuthController@handleProviderCallback');


Route::get('auth/facebook', 'Auth\FacebookAuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\FacebookAuthController@handleProviderCallback');


Auth::routes();