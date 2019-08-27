<?php

Route::domain('sss.' . env('DOMAIN_NAME', 'shrtd.local'))->group(function () {
    return 'ok';
});

// Auth
Route::get('register', 'Auth\RegisterController@showRegisterForm')->middleware('guest')->name('register');
Route::post('register', 'Auth\RegisterController@register')->middleware('guest')->name('register.attempt');
Route::get('login', 'Auth\LoginController@showLoginForm')->middleware('guest')->name('login');
Route::post('login', 'Auth\LoginController@login')->middleware('guest')->name('login.attempt');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


// URL shortener public
Route::post('shorten', 'UrlController@shorten')->name('shorten');

// Home Links
Route::get('/')->uses('DashboardController@landing')->name('home');
Route::get('dashboard')->uses('DashboardController@dashboard')->middleware('auth')->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('urls', 'UrlController@index')->name('urls');
    Route::get('urls/create', 'UrlController@create')->name('urls.create');
    Route::post('urls/store', 'UrlController@store')->name('urls.store');
    Route::get('urls/{url}/edit', 'UrlController@create')->name('urls.edit');
    Route::post('urls/{url}/update', 'UrlController@store')->name('urls.update');
});

// Users
Route::get('users')->name('users')->uses('UsersController@index')->middleware('remember', 'auth');
Route::get('users/create')->name('users.create')->uses('UsersController@create')->middleware('auth');
Route::post('users')->name('users.store')->uses('UsersController@store')->middleware('auth');
Route::get('users/{user}/edit')->name('users.edit')->uses('UsersController@edit')->middleware('auth');
Route::put('users/{user}')->name('users.update')->uses('UsersController@update')->middleware('auth');
Route::delete('users/{user}')->name('users.destroy')->uses('UsersController@destroy')->middleware('auth');
Route::put('users/{user}/restore')->name('users.restore')->uses('UsersController@restore')->middleware('auth');

// Images
Route::get('/img/{path}', 'ImagesController@show')->where('path', '.*');

// Organizations
Route::get('organizations')->name('organizations')->uses('OrganizationsController@index')->middleware('remember', 'auth');
Route::get('organizations/create')->name('organizations.create')->uses('OrganizationsController@create')->middleware('auth');
Route::post('organizations')->name('organizations.store')->uses('OrganizationsController@store')->middleware('auth');
Route::get('organizations/{organization}/edit')->name('organizations.edit')->uses('OrganizationsController@edit')->middleware('auth');
Route::put('organizations/{organization}')->name('organizations.update')->uses('OrganizationsController@update')->middleware('auth');
Route::delete('organizations/{organization}')->name('organizations.destroy')->uses('OrganizationsController@destroy')->middleware('auth');
Route::put('organizations/{organization}/restore')->name('organizations.restore')->uses('OrganizationsController@restore')->middleware('auth');

// Contacts
Route::get('contacts')->name('contacts')->uses('ContactsController@index')->middleware('remember', 'auth');
Route::get('contacts/create')->name('contacts.create')->uses('ContactsController@create')->middleware('auth');
Route::post('contacts')->name('contacts.store')->uses('ContactsController@store')->middleware('auth');
Route::get('contacts/{contact}/edit')->name('contacts.edit')->uses('ContactsController@edit')->middleware('auth');
Route::put('contacts/{contact}')->name('contacts.update')->uses('ContactsController@update')->middleware('auth');
Route::delete('contacts/{contact}')->name('contacts.destroy')->uses('ContactsController@destroy')->middleware('auth');
Route::put('contacts/{contact}/restore')->name('contacts.restore')->uses('ContactsController@restore')->middleware('auth');

// Reports
Route::get('reports')->name('reports')->uses('ReportsController')->middleware('auth');

Route::get('{url_code}')->name('short')->uses('UrlController@getUrl');
