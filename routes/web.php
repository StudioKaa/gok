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

Route::redirect('/home', '/');
Route::get('/', function(){

	if(!Auth::check())
	{
		return view('home');
	}
	elseif (Auth::user()->enrollment->state < \App\Enrollment::STATE_ENROLLED)
	{
		return redirect('/enrollments/my/continue');
	}
	else
	{
		return redirect('/enrollments/my');
	}

})->name('home');

Route::group(['middleware' => 'guest'], function() {

	Route::get('/enrollments/create', 'EnrollmentController@create');
	Route::post('/enrollments', 'EnrollmentController@store')->name('enrollments.create');

	Route::get('/login', 'LoginController@showLoginForm')->name('login');
	Route::post('/login', 'LoginController@login_form');
	Route::get('/login/{base64}', 'LoginController@login_decode');
	Route::get('/login/{base64}/{action}', 'LoginController@login_decode');

	Route::group(['prefix' => 'admin'], function() {
		Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
		Route::post('login', 'Admin\LoginController@login');
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

	Route::get('/ideal/pay/{slug}', 'IdealController@redirect')->name('ideal.pay');
	Route::get('/ideal/finish/{slug}', 'IdealController@finish')->name('ideal.finish');

	Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function() {

		Route::redirect('/', '/admin/enrollments')->name('admin.home');
		Route::get('/enrollments', 'Admin\EnrollmentController@index')->name('admin.enrollments.index');
		Route::get('/participants', 'ParticipantController@index')->name('admin.participants.index');
		
		Route::get('/terms', 'Admin\TermController@index')->name('admin.terms.index');
		Route::get('/terms/{term}/pay', 'Admin\TermController@pay')->name('admin.terms.pay');

	});

});

Route::get('/ideal/webhook', 'IdealController@webhook');

//Auth::routes();
Route::get('/logout', function(){
	Auth::logout();
	return redirect('home');
});