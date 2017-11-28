<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'home')->name('home');
Route::redirect('/home', '/');

Route::group(['middleware' => 'guest'], function() {
	Route::get('/enrollments/create', 'EnrollmentController@create');
	Route::post('/enrollments', 'EnrollmentController@store')->name('enrollments.create');

	Route::group(['prefix' => 'admin'], function() {
		Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
		Route::post('login', 'Auth\LoginController@login');
	});
});

Route::group(['middleware' => 'auth'], function() {

	Route::get('/enrollments/{slug}/continue', 'EnrollmentController@continue');
	Route::get('/enrollments/{slug}/participants/create/{n}', 'ParticipantController@create')->name('participants.create');
	Route::post('/enrollments/{slug}/participants', 'ParticipantController@store')->name('participants.store');
	Route::get('/enrollments/{slug}/contact', 'EnrollmentController@contact')->name('enrollments.contact');
	Route::post('/enrollments/{slug}/contact', 'EnrollmentController@contact_save')->name('enrollments.contact_save');
	Route::get('/enrollments/{slug}/payment', 'EnrollmentController@payment')->name('enrollments.payment');
	Route::post('/enrollments/{slug}/payment', 'EnrollmentController@payment_save')->name('enrollments.payment_save');
	Route::get('/enrollments/{slug}', 'EnrollmentController@show')->name('enrollments.show');

	Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function() {

		Route::view('/', 'admin.home')->name('admin.home');
		Route::get('/enrollments', 'Admin\EnrollmentController@index')->name('admin.enrollments.index');
		Route::get('/participants', 'ParticipantController@index')->name('admin.participants.index');
		Route::get('/terms', 'Admin\TermController@index')->name('admin.terms.index');

	});

});

//Auth::routes();
Route::get('/logout', function(){
	Auth::logout();
	return redirect('home');
});