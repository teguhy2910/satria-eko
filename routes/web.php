<?php
use App\Http\Middleware\CheckLogin;
Auth::routes();
Route::group(['middleware' => [CheckLogin::class]], function () {
Route::get('/', 'MainController@index');
});

/*SJ*/
Route::get('/dashboard','MainController@dashboard');
Route::get('/filter','MainController@filter');
Route::get('/sj/dashboard','MainController@sj_dashboard');
Route::get('/sj_r_f','MainController@sj_receive_fin');
Route::get('/sj_out','MainController@sj_out');
Route::get('/balik','MainController@balik');
Route::post('/balik','MainController@balik_store');
Route::get('/kirim_finance','MainController@kirim_finance');
Route::post('/kirim_finance','MainController@kirim_finance_store');
Route::get('/fin','MainController@fin');
Route::post('/fin','MainController@fin_store');
Route::post('/fin_upload','MainController@fin_upload');
// Route::get('/aii','MainController@aii');
// Route::post('/aii','MainController@aii_store');
Route::get('upload/sj/dashboard','MainController@upload_sj_dashboard');
Route::post('upload/sj/dashboard','MainController@store_upload_sj_dashboard');
Route::post('update_ppic_upload','MainController@store_sj_update');
Route::get('/del/{id}','MainController@del_ppic');