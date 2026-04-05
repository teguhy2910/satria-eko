<?php

use App\Http\Middleware\CheckLogin;

Auth::routes();

Route::group(['middleware' => [CheckLogin::class]], function () {
    Route::get('/', 'SjDashboardController@index');
});

// Dashboard & DataTables
Route::get('/dashboard', 'SjDashboardController@dashboard')->name('dashboard');
Route::get('/sj/dashboard', 'SjDashboardController@sjDashboard')->name('sj.dashboard');
Route::get('/sj_outstanding', 'SjDashboardController@sjOutstanding')->name('sj.outstanding');
Route::post('/data_sj', 'SjDashboardController@dataSj')->name('sj.data');
Route::post('/data_outstanding_sj', 'SjDashboardController@dataOutstandingSj')->name('sj.data-outstanding');
Route::post('/data_outstanding_sj_7_day', 'SjDashboardController@dataOutstandingSj7Day')->name('sj.data-outstanding-7day');
Route::post('/filter_view', 'SjDashboardController@filterView')->name('sj.filter');

// Upload SJ
Route::get('/upload/sj/dashboard', 'SjCrudController@uploadSjForm')->name('sj.upload-form');
Route::post('/upload/sj/dashboard', 'SjCrudController@uploadSj')->name('sj.upload');

// CRUD SJ
Route::get('/create/sj', 'SjCrudController@create')->name('sj.create');
Route::post('/create/sj', 'SjCrudController@store')->name('sj.store');
Route::get('/edit_sj/{id}', 'SjCrudController@edit')->name('sj.edit');
Route::post('/edit_sj/{id}', 'SjCrudController@update')->name('sj.update');
Route::get('/delete_sj/{id}', 'SjCrudController@destroy')->name('sj.delete');
Route::get('/download_sj', 'SjCrudController@downloadSj')->name('sj.download');

// SJ Balik
Route::get('/sj_balik', 'SjBalikController@index')->name('sj-balik.index');
Route::post('/sj_balik', 'SjBalikController@scanStore')->name('sj-balik.scan');
Route::post('/update_sj_balik_ppic_upload', 'SjBalikController@uploadStore')->name('sj-balik.upload');

// Terima Finance
Route::get('/terima_finance', 'TerimaFinanceController@index')->name('finance.index');
Route::post('/terima_finance', 'TerimaFinanceController@scanStore')->name('finance.scan');
Route::post('/update_fin_upload', 'TerimaFinanceController@uploadStore')->name('finance.upload');
