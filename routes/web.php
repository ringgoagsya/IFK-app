<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ObatController;

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

Route::get('/', function () {
    // dd($user);
    if(auth()->guest()){
        return redirect('home');
    }
    else if(auth()->user()->level == 'user'){
        return redirect('/puskesmas');
    }else{
        return redirect('home');
    }
});

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => ['auth','ceklevel:user']], function () {
    Route::get('/dashboard', 'App\Http\Controllers\HomeController@index_puskesmas')->name('home.puskesmas');
    //Puskesmas stok obat
    Route::get('/puskesmas', 'App\Http\Controllers\PuskesmasController@index')->name('puskesmas');
    Route::get('/puskesmas-obat', 'App\Http\Controllers\PuskesmasController@obat')->name('puskesmas.obat');
    Route::get('/puskesmas-stok-obat', 'App\Http\Controllers\PuskesmasController@stokobat')->name('puskesmas-stok.obat');
    //Puskesmas Obat Masuk
    Route::get('/puskesmas-masuk', 'App\Http\Controllers\PuskesmasController@obat_masuk')->name('puskesmas.masuk');
    Route::post('/puskesmas-masuk/tanggal', 'App\Http\Controllers\PuskesmasController@masuk_filter')->name('puskesmas-masuk.filter');
    //Puskesmas Obat Keluar
    Route::get('/puskesmas-keluar', 'App\Http\Controllers\KeluarPuskesmasController@index')->name('puskesmas.keluar');
    Route::post('/puskesmas-keluar/post', 'App\Http\Controllers\KeluarPuskesmasController@store')->name('puskesmas-keluar.store');
    Route::post('/puskesmas-keluar/update/{id}', 'App\Http\Controllers\KeluarPuskesmasController@update')->name('puskesmas-keluar.update');
    Route::delete('/puskesmas-keluar/delete/{id}','App\Http\Controllers\KeluarPuskesmasController@destroy')->name('keluar-puskesmas.destroy');
    Route::post('/puskesmas-keluar/tanggal','App\Http\Controllers\KeluarPuskesmasController@filter')->name('puskesmas-keluar.filter');
    //Puskesmas LPLPO
    Route::get('/puskesmas/lplpo', 'App\Http\Controllers\LplpoPuskesmasController@index')->name('lplpo.index');
    Route::post('/puskesmas/lplpo/{id}', 'App\Http\Controllers\LplpoPuskesmasController@edit')->name('lplpo.edit');
    Route::post('/puskesmas-lplpo/tanggal', 'App\Http\Controllers\LplpoPuskesmasController@lplpo_filter')->name('lplpo-cetak.filter');
    Route::get('/puskesmas/lplpo/{id_obat}/{id_pus}/{stok_awal}/{penerimaan_awal}/{pemakaian_awal}/{sisa}/{persediaan}/{now}', 'App\Http\Controllers\LplpoPuskesmasController@confirm')->name('lplpo.confirm');
});
Route::group(['middleware' => ['auth','ceklevel:admin']], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	//Route buat pindah halaman sidebar
     //Route Obat
     Route::get('/obat','App\Http\Controllers\ObatController@index')->name('obat.index');
     Route::post('/obat-post','App\Http\Controllers\ObatController@store')->name('obat.store');
     Route::patch('/obat-edit/{id}','App\Http\Controllers\ObatController@edit')->name('obat.edit');
     Route::delete('/obat-hapus/{id}','App\Http\Controllers\ObatController@destroy')->name('obat.destroy');

     //Route User
     Route::get('/user','App\Http\Controllers\UserController@user')->name('puskesmas-user.index');
     Route::post('/user-post','App\Http\Controllers\UserController@store')->name('user.store');
     Route::post('/user-post/{id}','App\Http\Controllers\UserController@update')->name('user.update');
     Route::delete('/user-hapus/{id}','App\Http\Controllers\UserController@destroy')->name('user.destroy');

     //Route User
     Route::get('/show','App\Http\Controllers\PuskesmasController@show')->name('puskesmas-show.index');
     Route::post('/show-post','App\Http\Controllers\PuskesmasController@store')->name('show.store');
     Route::post('/show-post/{id}','App\Http\Controllers\PuskesmasController@update')->name('show.update');
     Route::delete('/show-hapus/{id}','App\Http\Controllers\PuskesmasController@destroy')->name('show.destroy');

     //Route Stok Obat
     Route::get('/stok-obat','App\Http\Controllers\StokObatController@index')->name('stokobat.index');
     Route::post('/stok-obat-post','App\Http\Controllers\StokObatController@store')->name('stokobat.store');
     Route::get('/stok-obat-induk','App\Http\Controllers\StokObatController@indexinduk')->name('stokobatinduk.index');
     Route::get('/stok-obat-induk-print','App\Http\Controllers\StokObatController@export')->name('export.index');


     Route::post('/stok-obat-induk/tanggal','App\Http\Controllers\StokObatController@indexfilter')->name('stokfilter.index');

     //Route Pemasok
     Route::get('/pemasok','App\Http\Controllers\PemasokController@index')->name('pemasok.index');
     Route::post('/pemasok-post','App\Http\Controllers\PemasokController@store')->name('pemasok.store');
     Route::patch('/pemasok-edit/{id}','App\Http\Controllers\PemasokController@edit')->name('pemasok.edit');
     Route::delete('/pemasok-hapus/{id}','App\Http\Controllers\PemasokController@destroy')->name('pemasok.destroy');

     //Route Detail Obat Masuk
     Route::get('/detail-obat-masuk','App\Http\Controllers\ObatMasukController@index')->name('obat-masuk.index');
     Route::post('/detail-obat-masuk-post','App\Http\Controllers\ObatMasukController@store')->name('obat-masuk.store');
     Route::post('/detail-obat-masuk-update/{id}','App\Http\Controllers\ObatMasukController@update')->name('obat-masuk.update');
     Route::delete('/detail-obat-masuk-hapus/{id}','App\Http\Controllers\ObatMasukController@destroy')->name('obat-masuk.destroy');
     //Route Obat
     Route::get('/obat-masuk','App\Http\Controllers\DetailObatMasukController@index')->name('masuk.index');
     Route::post('/obat-masuk-post','App\Http\Controllers\DetailObatMasukController@store')->name('masuk.store');
     Route::post('/obat-masuk-update/{id}','App\Http\Controllers\DetailObatMasukController@update')->name('masuk.update');
     Route::delete('/obat-masuk-hapus/{id}','App\Http\Controllers\DetailObatMasukController@destroy')->name('masuk.destroy');

     Route::post('/obat-masuk/tanggal','App\Http\Controllers\ObatMasukController@filter')->name('obat-masuk.filter');
     //Route Obat Keluar
     Route::get('/obat-keluar','App\Http\Controllers\ObatKeluarController@index')->name('obat-keluar.index');
     Route::post('/obat-keluar-post','App\Http\Controllers\ObatKeluarController@store')->name('obat-keluar.store');
     Route::post('/obat-keluar-update/{id}','App\Http\Controllers\DetailObatkeluarController@update')->name('obat-keluar.update');
     Route::delete('/obat-keluar-hapus/{id}','App\Http\Controllers\DetailObatkeluarController@destroy')->name('obat-keluar.destroy');

     Route::post('/obat-keluar/tanggal','App\Http\Controllers\ObatKeluarController@filter')->name('obat-keluar.filter');
     //Route expired data
    //  Route::get('/','App\Http\Controllers\StokObatController@expired')->name('expired');
     //Route Perencanaan Obat
     Route::get('/obat-laporan','App\Http\Controllers\ObatKeluarController@laporan')->name('laporan.index');
     Route::get('/obat-laporan/puskesmas','App\Http\Controllers\LplpoPuskesmasController@admin')->name('laporan-puskesmas.index');
     Route::post('/obat-laporan/puskesmas/tanggal','App\Http\Controllers\LplpoPuskesmasController@admin_filter')->name('laporan-puskesmas.filter');

     //cetak laporan

     Route::get('/print/bukustok/{now}','App\Http\Controllers\LplpoPuskesmasController@exportbuku')->name('print.buku');
     Route::get('/print/perencanaan/{now}','App\Http\Controllers\LplpoPuskesmasController@exportperencanaan')->name('print.perencanaan');

	});
Route::get('/print/lplpo/{now}/{user}','App\Http\Controllers\LplpoPuskesmasController@exportlplpo')->name('print.index');

Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
Route::post('/profile/{id}','App\Http\Controllers\PuskesmasController@profile')->name('update.puskesmas');



