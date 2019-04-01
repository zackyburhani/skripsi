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
Route::get('/export-crawling', 'ControllerCrawlingTwitter@export')->name('export-crawling');
Route::post('/upload-crawling', 'ControllerCrawlingTwitter@upload')->name('upload-crawling');

//singkatan
Route::get('/singkatan', 'ControllerKosaKata@singkatan');
Route::post('/singkatan','ControllerKosaKata@store_singkatan');
Route::get('/singkatan_all','ControllerKosaKata@all_singkatan');
Route::get('/singkatan/{singkatan}','ControllerKosaKata@get_singkatan');
Route::put('/singkatan/{singkatan}','ControllerKosaKata@update_singkatan');
Route::delete('/singkatan/{singkatan}','ControllerKosaKata@delete_singkatan');

//emoticon
Route::get('/emoticon', 'ControllerKosaKata@emoticon');
Route::post('/emoticon','ControllerKosaKata@store_emoticon');
Route::get('/emoticon_all','ControllerKosaKata@all_emoticon');
Route::get('/emoticon/{emoticon}','ControllerKosaKata@get_emoticon');
Route::put('/emoticon/{emoticon}','ControllerKosaKata@update_emoticon');
Route::delete('/emoticon/{emoticon}','ControllerKosaKata@delete_emoticon');

// preprocessing
Route::get('/preprocessing', 'ControllerPreprocessing@preprocessing');

