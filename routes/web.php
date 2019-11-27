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

use App\Http\Controllers\operationalController;

Route::get('/', "PagesController@home");
Route::get('/home', "PagesController@home");
Route::get('/operational', "PagesController@operational");
Route::get('/denotational', "PagesController@denotational");
Route::get('/axiomatic', "PagesController@axiomatic");
Route::get('/about', "PagesController@about");

Route::post("/operational", "operationalController@onFormOperational");
Route::post("/denotational", "operationalController@onFormDenotational");
Route::post("/axiomatic", "operationalController@onFormAxiomatic");
