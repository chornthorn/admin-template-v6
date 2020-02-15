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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web', 'namespace' => 'Auth'], function () {

//    Auth::routes();
    /*
    * login
    */
    Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('login', 'LoginController@login');
    /*
    * Logout
    */
    Route::post('logout', 'LoginController@logout')->name('logout');
    /*
    * Register
    */
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');
    /*
    * Password
    */
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    Route::get('password/confirm', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'ConfirmPasswordController@confirm');
    /*
    * Verify Password
    */
    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');

});

Route::group(['middleware' => 'auth'], function () {

    /*
     * Home URL
     */
    Route::get('/', 'HomeController@index')->name('home');
    /*
     * Route Role
     */
    Route::resource('/role', 'RoleController');
    Route::get('role/{role_id}/users', 'RoleController@user')->name('role.users');
    Route::get('roles/export', 'RoleController@export')->name('role.export');
    /*
     * Route User
     */
    Route::resource('/user', 'UserController');
    /*
     * Route Category
     */
    /*Route::resource('/categories', 'CategoryController');
    Route::delete('/delete','CategoryController@deleteAll')->name('category.deleteAll');
    Route::get('category/export', 'CategoryController@exportCategory')->name('categories.export');
    Route::post('category/import', 'CategoryController@import')->name('categories.import');
    Route::get('category/pdf','CategoryController@pdf')->name('categories.pdf');*/

});

