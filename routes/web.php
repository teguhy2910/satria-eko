<?php
use App\Http\Middleware\CheckLogin;
Auth::routes();
Route::group(['middleware' => [CheckLogin::class]], function () {
Route::get('/', 'MainController@index');
});
Route::get('/dashboard','MainController@dashboard');
Route::get('/sj/dashboard','MainController@sj_dashboard');
Route::get('upload/sj/dashboard','MainController@upload_sj_dashboard');
Route::post('upload/sj/dashboard','MainController@upload_sj_dashboard_store');
Route::get('/sj_balik','MainController@sj_balik');
Route::post('/sj_balik','MainController@sj_balik_store');
Route::post('update_sj_balik_ppic_upload','MainController@update_sj_balik_ppic_upload');
Route::post('update_kirim_finance_ppic_upload','MainController@update_kirim_finance_ppic_upload');
Route::get('/kirim_finance','MainController@kirim_finance');
Route::post('/kirim_finance','MainController@kirim_finance_store');
Route::get('/terima_finance','MainController@terima_finance');
Route::post('/terima_finance','MainController@terima_finance_store');
Route::post('/update_fin_upload','MainController@update_fin_upload');
Route::get('/del/{id}','MainController@del_ppic');
Route::get('/filter','MainController@filter');
Route::get('/sj_outstanding','MainController@sj_outstanding');
Route::post('/data_sj','MainController@data_sj');
// Route::get('/aii','MainController@aii');
// Route::post('/aii','MainController@aii_store');
// Route::get('/sj_r_f','MainController@sj_receive_fin');
