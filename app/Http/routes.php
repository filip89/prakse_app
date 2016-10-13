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

Route::get('/','HomeController@index');

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

//edit student
Route::get('user/{id}/editstudent', "UserController@editStudentForm");
Route::post('user/{id}/editstudent', "UserController@editStudent");

//admin
Route::post('user/admin/{id}', 'UserController@admin');

//edit intern_mentor
Route::get('user/{id}/editintern', "UserController@editInternMentorForm");
Route::post('user/{id}/editintern', "UserController@editInternMentor");

//profile pic
Route::post('user/image/add', "UserController@addImage");
Route::post('user/image/delete/{id}', "UserController@deleteImage");

//committee
Route::get('committee', "CommitteeController@index");
Route::post('committee/create', "CommitteeController@create");
Route::post('committee/delete/{id}', "CommitteeController@delete");

//lista prijava
Route::get('applics', "ApplicController@index");
Route::get('applics/former', "ApplicController@former");

//'profil' prijave - studenta
Route::get('myapplic/', "ApplicController@myApplic");

Route::get('applic/{id}', "ApplicController@view");

//prijava
Route::get('apply/{id?}', "ApplicController@applyForm");
Route::post('apply', "ApplicController@apply");

//posljednja praksa od studenta
Route::get('myinternship', "UserController@myInternship");

//lista praksi
Route::get('user_internships/{id?}', "UserController@userInternships");
Route::get('company_internships/{id}', "CompanyController@companyInternships");

//brisanje i editiranje prijave
Route::post('applic/delete/{id}', "ApplicController@delete");

//rute za tvrtku
Route::get('company', 'CompanyController@index');
Route::get('company/wishlist', 'CompanyController@wishlist');
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
Route::any('internships/statistics', 'InternshipController@getStatistics');
Route::any('internships/statisticsReport', 'InternshipController@statisticsReport');
Route::get('internships/showFinal', "InternshipController@showFinal");
Route::get('internships/showResults', "InternshipController@showResults");
Route::post('internships/comment', "InternshipController@comment");
Route::post('internships/rejectionComment', "InternshipController@rejectionComment");
Route::post('internships/addMentor/{id}', "InternshipController@addMentor");
Route::post('internships/removeMentor/{id}', "InternshipController@removeMentor");
Route::post('internships/addCompany', "InternshipController@addCompany");
Route::post('internships/rating', "InternshipController@starRating");
Route::any('internships/change/{id}', "InternshipController@change");
Route::resource('internships', "InternshipController", ['except' => ['store', 'update']]);

//competition
Route::post('competition/create', 'CompetitionController@store');
Route::post('competition/close', 'CompetitionController@close');
Route::post('competition/archive', 'CompetitionController@archive');
Route::post('competition/edit/{id}', 'CompetitionController@edit');

//settings
Route::get('settings','SettingController@open');

//complaints
Route::get('complaint/{id}', 'ComplaintController@view');
Route::get('complaints/', 'ComplaintController@index');
Route::get('complaint', 'ComplaintController@viewForm');
Route::post('complaint/status/{id}', 'ComplaintController@status');
Route::post('complaint/create', 'ComplaintController@create');
Route::post('complaint/delete/{id}', 'ComplaintController@delete');
