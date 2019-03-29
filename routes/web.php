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

Route::get('/', 'ControllerDashboard@index');

//crawling twitter
Route::get('/crawling', 'ControllerCrawlingTwitter@index')->name('crawling.index');
Route::post('/crawling', 'ControllerCrawlingTwitter@crawling_data')->name('crawling.crawling_data');

//kosa kata
Route::get('/singkatan', 'ControllerKosaKata@singkatan');
Route::get('/emoticon', 'ControllerKosaKata@emoticon');

// preprocessing
Route::get('/preprocessing', 'ControllerPreprocessing@preprocessing');
