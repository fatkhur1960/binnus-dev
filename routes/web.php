<?php

Route::get('/', function () {
    return view('main');
});
Route::get('/daftar-kursus', function() {
    $agama = \App\ModelAgama::all();
    $paket = \App\ModelPaket::all();
    $sumber = \App\ModelSumber::all();

    return view('daftar', compact('agama','paket','sumber'));
});

Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/get-jadwal', 'HomeController@getJadwal')->name('get.jadwal');
    Route::get('/home/akun', 'AkunController@index');
    Route::post('/changePassword','AkunController@changePassword')->name('changePassword');
    
    Route::prefix('home')->group(function () {

        Route::group(['middleware' => ['role:admin']], function () {
            Route::resources([
                'paket-kursus'  => 'PaketController',
                'jadwal-kursus' => 'JadwalController',
                'histori-pembayaran'    => 'OrderController',
                'peserta'               => 'PesertaController'
            ]);
            Route::post('get-peserta', 'PesertaController@getPeserta');
        });

        Route::group(['middleware' => ['role:user']], function () {
            Route::post('update-profile', 'HomeController@update_profile')->name('update_profile');
            Route::post('confirm', 'HomeController@confirm')->name('confirm');
            Route::get('cancel/{id}', 'HomeController@cancel')->name('cancel');
            Route::get('pembayaran', 'HomeController@pembayaran')->name('pembayaran');
            Route::get('profil', 'HomeController@profile')->name('reg_form');
            Route::get('pilih-paket-kursus', 'HomeController@paketKursus')->name('pilih.paket');
            Route::get('get-paket', 'HomeController@getPaket')->name('get.paket');
            Route::post('ambil-paket', 'HomeController@ambilPaket')->name('ambil.paket');
            Route::post('ambil-jadwal', 'HomeController@ambilJadwal')->name('ambil.jadwal');
        });
    
    });
});