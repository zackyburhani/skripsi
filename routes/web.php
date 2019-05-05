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
Route::get('/export-crawling/{export}', 'ControllerCrawlingTwitter@export')->name('export-crawling');
Route::post('/upload-crawling', 'ControllerCrawlingTwitter@upload')->name('upload-crawling');
Route::delete('/crawling/{crawling}','ControllerCrawlingTwitter@destroy_crawling');
Route::put('/crawling/{crawling}','ControllerCrawlingTwitter@update_crawling');

//kata_dasar
Route::get('/kata-dasar', 'ControllerKosaKata@kata_dasar');
Route::post('/kata-dasar','ControllerKosaKata@store_kata_dasar');
Route::get('/kata-dasar-all','ControllerKosaKata@all_kata_dasar');
Route::get('/kata-dasar/{kata_dasar}','ControllerKosaKata@get_kata_dasar');
Route::put('/kata-dasar/{kata_dasar}','ControllerKosaKata@update_kata_dasar');
Route::delete('/kata-dasar/{kata_dasar}','ControllerKosaKata@delete_kata_dasar');

//emoticon
Route::get('/emoticon', 'ControllerKosaKata@emoticon');
Route::post('/emoticon','ControllerKosaKata@store_emoticon');
Route::get('/emoticon_all','ControllerKosaKata@all_emoticon');
Route::get('/emoticon/{emoticon}','ControllerKosaKata@get_emoticon');
Route::put('/emoticon/{emoticon}','ControllerKosaKata@update_emoticon');
Route::delete('/emoticon/{emoticon}','ControllerKosaKata@delete_emoticon');

//emoticon
Route::get('/stopword', 'ControllerKosaKata@stopword');
Route::post('/stopword','ControllerKosaKata@store_stopword');
Route::get('/stopword_all','ControllerKosaKata@all_stopword');
Route::get('/stopword/{stopword}','ControllerKosaKata@get_stopword');
Route::put('/stopword/{stopword}','ControllerKosaKata@update_stopword');
Route::delete('/stopword/{stopword}','ControllerKosaKata@delete_stopword');

// preprocessing
Route::get('/preprocessing', 'ControllerPreprocessing@preprocessing');
Route::post('/preprocessing', 'ControllerPreprocessing@store_preprocessing');
Route::post('/data-latih', 'ControllerPreprocessing@data_latih');
Route::post('/data-uji', 'ControllerPreprocessing@data_uji');

//training
Route::get('/training', 'ControllerTraining@index');

// analisa
Route::get('/analisa', 'ControllerAnalisa@index');
Route::get('/data-klasifikasi', 'ControllerAnalisa@klasifikasi');
Route::get('/confusion-matrix', 'ControllerAnalisa@confusion_matrix');
Route::get('/word-cloud', 'ControllerAnalisa@word_cloud');
Route::get('/data-cloud/{data}', 'ControllerAnalisa@data_cloud');
Route::get('/prediksi-sentimen', 'ControllerAnalisa@prediksi');
Route::get('/data-sentimen/{data-sentimen}', 'ControllerAnalisa@data_prediksi');

// Stemming
// Route::get('/stemming', 'ControllerPreprocessing@stemming_tes');
// Route::post('/stemming', 'ControllerPreprocessing@stemming');