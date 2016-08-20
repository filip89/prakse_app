<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/user', 'UserController@index');

Route::get('user/{id}', "UserController@viewProfile");

//delete any user
Route::post('user/{id}/delete', "UserController@deleteUser");

//edit college_mentor
Route::get('user/{id}/editcollege', "UserController@editCollegeMentorForm");
Route::post('user/{id}/editcollege', "UserController@editCollegeMentor");

//edit intern_mentor
Route::get('user/{id}/editintern', "UserController@editInternMentorForm");
Route::post('user/{id}/editintern', "UserController@editInternMentor");

//prijava prakse
Route::get('apply', "ApplicController@applyForm");
Route::post('apply/{id}', "ApplicController@apply");
