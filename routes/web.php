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

Route::get('/', 'AboutController')->name('home');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/software-usability', 'SoftwareUsabilityController@index')->name('software_usability.index');
Route::get('/software-usability/analyze', 'SoftwareUsabilityController@analyze')->name('software_usability.analyze');

Route::get('/data-generator', 'DataGeneratorController@index')->name('data_generator.index');
Route::get('/data-generator/truncate', 'DataGeneratorController@truncate')->name('data_generator.truncate');
Route::get('/data-generator/generate-random-data', 'DataGeneratorController@generateRandomData')->name('data_generator.generate_random_data');
Route::get('/data-generator/generate-article-test-data', 'DataGeneratorController@generateArticleTestData')->name('data_generator.generate_article_test_data');
