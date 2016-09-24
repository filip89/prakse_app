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

Route::get('/user/student/list', 'UserController@studentIndex');
Route::get('/user/intern_mentor/list', 'UserController@internMentorIndex');
Route::get('/user/college_mentor/list', 'UserController@collegeMentorIndex');
Route::get('user/{id}', "UserController@viewProfile");

//delete any user
Route::post('user/{id}/delete', "UserController@deleteUser");

//edit college_mentor
Route::get('user/{id}/editcollege', "UserController@editCollegeMentorForm");
Route::post('user/{id}/editcollege', "UserController@editCollegeMentor");

//add intern_mentor
Route::get('user/add/internmentor/{id?}', 'UserController@addInternMentorForm');
Route::post('user/add/internmentor', 'UserController@addInternMentor');

//edit intern_mentor
Route::get('user/{id}/editintern', "UserController@editInternMentorForm");
Route::post('user/{id}/editintern', "UserController@editInternMentor");

//'profil' prijave - studenta
Route::get('myapplic/', "ApplicController@myApplic");
//prijava
Route::get('apply/{id?}', "ApplicController@applyForm");
Route::post('apply', "ApplicController@apply");

//lista prijava
Route::get('applic/all', "ApplicController@index");

//posljednja praksa od studenta
Route::get('myinternship', "UserController@myInternship");
//lista praksi
Route::get('user_internships/{id?}', "UserController@userInternships");
Route::get('company_internships/{id}', "CompanyController@companyInternships");

//brisanje i editiranje prijave
Route::post('applic/{id}/delete', "ApplicController@delete");
//Route::post('applic/{id}/edit', "ApplicController@edit");

//rute za tvrtku
Route::get('company', 'CompanyController@index');
Route::get('company/wishlist', 'CompanyController@wishlist');
Route::get('company/former', 'CompanyController@former');
Route::post('company/reinstate/{id}', 'CompanyController@reinstate');
Route::get('company/profile/{id}', 'CompanyController@profile');
Route::get('company/create', 'CompanyController@createForm');
Route::post('company/create', 'CompanyController@create');
Route::get('company/edit/{id}', 'CompanyController@editForm');
Route::post('company/edit/{id}', 'CompanyController@edit');
Route::post('company/delete/{id}', 'CompanyController@delete');

//prakse
Route::any('internships/document', 'InternshipController@getPDF');
Route::any('internships/createReport', 'InternshipController@createReport');
Route::any('internships/report', 'InternshipController@getReport');
Route::get('internships/showFinal', "InternshipController@showFinal");
Route::get('internships/showResults', "InternshipController@showResults");
Route::any('internships/reject', "InternshipController@reject");
Route::post('internships/addMentor/{id}', "InternshipController@addMentor");
Route::post('internships/removeMentor/{id}', "InternshipController@removeMentor");
Route::any('internships/change/{id}', "InternshipController@change");
Route::resource('internships', "InternshipController", ['except' => ['store', 'update']]);

//competition
Route::post('competition/create', 'CompetitionController@store');
Route::post('competition/close', 'CompetitionController@close');
Route::post('competition/archive', 'CompetitionController@archive');
Route::post('competition/edit/{id}', 'CompetitionController@edit');

//settings
Route::get('settings','SettingController@competition');
