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
Route::get('/search-page', 'ControllerDashboard@searchPage');

//crawling twitter
Route::get('/crawling', 'ControllerCrawlingTwitter@index')->name('crawling.index');
Route::post('/crawling', 'ControllerCrawlingTwitter@crawling_data')->name('crawling.crawling_data');
Route::get('/export-crawling/{export}', 'ControllerCrawlingTwitter@export')->name('export-crawling');
Route::post('/upload-crawling', 'ControllerCrawlingTwitter@upload')->name('upload-crawling');
Route::delete('/crawling/{crawling}','ControllerCrawlingTwitter@destroy_crawling');
Route::put('/crawling/{crawling}','ControllerCrawlingTwitter@update_crawling');
Route::get('/refresh-crawling','ControllerCrawlingTwitter@refresh_crawling');

//kata_dasar
Route::get('/kata-dasar', 'ControllerKosaKata@kata_dasar');
Route::post('/kata-dasar','ControllerKosaKata@store_kata_dasar');
Route::get('/kata-dasar-all','ControllerKosaKata@all_kata_dasar');
Route::get('/kata-dasar/{kata_dasar}','ControllerKosaKata@get_kata_dasar');
Route::put('/kata-dasar/{kata_dasar}','ControllerKosaKata@update_kata_dasar');
Route::delete('/kata-dasar/{kata_dasar}','ControllerKosaKata@delete_kata_dasar');

//kategori-sentimen
Route::get('/kategori-sentimen', 'ControllerKategori@kategori');
Route::post('/kategori-sentimen','ControllerKategori@store_kategori');
Route::get('/kategori-sentimen-all','ControllerKategori@all_kategori');
Route::get('/kategori-sentimen/{kategori}','ControllerKategori@get_kategori');
Route::put('/kategori-sentimen/{kategori}','ControllerKategori@update_kategori');
Route::delete('/kategori-sentimen/{kategori}','ControllerKategori@delete_kategori');

//stopword
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
Route::get('/hapus-training/{training}', 'ControllerTraining@hapus_training');
Route::get('/data-sentimen', 'ControllerTraining@data_sentimen');

// analisa
Route::get('/analisa', 'ControllerAnalisa@index');
Route::get('/data-klasifikasi', 'ControllerAnalisa@klasifikasi');
Route::get('/confusion-matrix', 'ControllerAnalisa@confusion_matrix');
Route::get('/word-cloud', 'ControllerAnalisa@word_cloud');
Route::get('/data-cloud/{data}', 'ControllerAnalisa@data_cloud');
Route::get('/prediksi-sentimen', 'ControllerAnalisa@prediksi');
Route::get('/data-sentimen/{data-sentimen}', 'ControllerAnalisa@data_prediksi');
Route::get('/column-drilldown', 'ControllerAnalisa@column_drilldown');
Route::get('/jumlah-kategori-cloud', 'ControllerAnalisa@jumlah_kategori_cloud');

// Stemming
// Route::get('/stemming', 'ControllerPreprocessing@stemming_tes');
// Route::post('/stemming', 'ControllerPreprocessing@stemming');