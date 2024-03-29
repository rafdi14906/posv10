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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', function () {
  return redirect()->route('home');
})->name('base');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'superadmin']], function () {
  Route::get('/user', ['as' => 'Master User', 'uses' => 'UserController@listUser']);
  Route::get('/user/detail/{id}', ['Detail User', 'uses' => 'UserController@detailUser']);
  Route::post('/user/detail', ['as' => 'Save User', 'uses' => 'UserController@saveUser']);
  Route::get('/user/delete/{id}', ['as' => 'Delete User', 'uses' => 'UserController@deleteUser']);
});

Route::group(['middleware' => ['auth', 'admin']], function () {
  Route::get('/kategori', ['as' => 'Master Kategori', 'uses' => 'MstKategoriController@listKategori']);
  Route::post('/kategori', ['as' => 'Save Kategori', 'uses' => 'MstKategoriController@saveKategori']);
  Route::get('/kategori/delete/{id}', ['as' => 'Delete Kategori', 'uses' => 'MstKategoriController@deleteKategori']);
});

Route::get('/barang', ['as' => 'Master Barang', 'uses' => 'MstBarangController@listBarang']);

Route::group(['middleware' => ['auth', 'admin']], function () {
  Route::get('/barang/detail/{id}', ['as' => 'Detail Barang', 'uses' => 'MstBarangController@detailBarang']);
  Route::post('/barang/detail', ['as' => 'Save Barang', 'uses' => 'MstBarangController@saveBarang']);
  Route::get('/barang/delete/{id}', ['as' => 'Delete Barang', 'uses' => 'MstBarangController@deleteBarang']);
});

Route::post('/barang/findOneBarang', ['as' => 'Find One Barang', 'uses' => 'MstBarangController@findOneBarang']);

Route::group(['middleware' => ['auth', 'admin']], function () {
  Route::get('/supplier', ['as' => 'Master Supplier', 'uses' => 'MstSupplierController@listSupplier']);
  Route::get('/supplier/detail/{id}', ['as' => 'Detail Supplier', 'uses' => 'MstSupplierController@detailSupplier']);
  Route::post('/supplier/detail', ['as' => 'Save Supplier', 'uses' => 'MstSupplierController@saveSupplier']);
  Route::get('/supplier/delete/{id}', ['as' => 'Delete Supplier', 'uses' => 'MstSupplierController@deleteSupplier']);
});

Route::get('/customer', ['as' => 'Master Customer', 'uses' => 'MstCustomerController@listCustomer']);
Route::get('/customer/detail/{id}', ['as' => 'Detail Customer', 'uses' => 'MstCustomerController@detailCustomer']);
Route::post('/customer/detail', ['as' => 'Save Customer', 'uses' => 'MstCustomerController@saveCustomer']);
Route::group(['middleware' => ['auth', 'admin']], function () {
  Route::get('/customer/delete/{id}', ['as' => 'Delete Customer', 'uses' => 'MstCustomerController@deleteCustomer']);
});

Route::group(['middleware' => ['auth', 'admin']], function () {
  Route::get('/pembelian', ['as' => 'Transaksi Pembelian', 'uses' => 'TrxPembelianController@listPembelian']);
  Route::get('/pembelian/detail', ['as' => 'Detail Pembelian', 'uses' => 'TrxPembelianController@detailPembelian']);
  Route::post('/pembelian/numbering', ['as' => 'Get Numbering Pembelian', 'uses' => 'TrxPembelianController@getNumberingPembelian']);
  Route::post('/pembelian/detail/saveDetail', ['as' => 'Save Detail Pembelian', 'uses' => 'TrxPembelianController@saveDetailPembelian']);
  Route::post('/pembelian/detail/loadDetail', ['as' => 'Load Detail Pembelian', 'uses' => 'TrxPembelianController@loadDetailPembelian']);
  Route::post('/pembelian/detail/deleteDetail', ['as' => 'Delete Detail Pembelian', 'uses' => 'TrxPembelianController@deleteDetailPembelian']);
  Route::post('/pembelian/detail', ['as' => 'Save Pembelian', 'uses' => 'TrxPembelianController@savePembelian']);
  Route::get('/pembelian/view/{id}', ['as' => 'View Pembelian', 'uses' => 'TrxPembelianController@viewPembelian']);
  Route::get('/pembelian/print/{id}', ['as' => 'Print Pembelian', 'uses' => 'TrxPembelianController@printPembelian']);
});

Route::get('/penjualan', ['as' => 'Transaksi Penjualan', 'uses' => 'TrxPenjualanController@listPenjualan']);
Route::get('/penjualan/detail', ['as' => 'Detail Penjualan', 'uses' => 'TrxPenjualanController@detailPenjualan']);
Route::post('/penjualan/detail/loadStokBarang', ['as' => 'Load Stok Barang Penjualan', 'uses' => 'TrxPenjualanController@loadStokBarangPenjualan']);
Route::post('/penjualan/detail/loadDetail', ['as' => 'Load Detail Penjualan', 'uses' => 'TrxPenjualanController@loadDetailPenjualan']);
Route::post('/penjualan/detail/saveDetail', ['as' => 'Save Detail Penjualan', 'uses' => 'TrxPenjualanController@saveDetailPenjualan']);
Route::post('/penjualan/detail/loadDetail', ['as' => 'Load Detail Penjualan', 'uses' => 'TrxPenjualanController@loadDetailPenjualan']);
Route::post('/penjualan/detail/deleteDetail', ['as' => 'Delete Detail Penjualan', 'uses' => 'TrxPenjualanController@deleteDetailPenjualan']);
Route::post('/penjualan/detail', ['as' => 'Save Penjualan', 'uses' => 'TrxPenjualanController@savePenjualan']);
Route::get('/penjualan/print/{id}', ['as' => 'Print Invoice Penjualan', 'uses' => 'TrxPenjualanController@printInvoicePenjualan']);
Route::get('/penjualan/view/{id}', ['as' => 'View Penjualan', 'uses' => 'TrxPenjualanController@viewPenjualan']);

Route::get('/gudang', ['as' => 'Gudang', 'uses' => 'TrxGudangController@listGudang']);
Route::get('/gudang/detail/{id}', ['as' => 'Detail Gudang', 'uses' => 'TrxGudangController@detailGudang']);
Route::post('/gudang/penyesuaian', ['as' => 'Penyesuaian Stok', 'uses' => 'TrxGudangController@penyesuaianStok']);

Route::group(['middleware' => ['auth', 'admin']], function () {
  Route::get('/hutang', ['as' => 'Hutang', 'uses' => 'TrxHutangController@listHutang']);
  Route::get('/hutang/detail/{id}', ['as' => 'Detail Hutang', 'uses' => 'TrxHutangController@detailHutang']);
  Route::post('/hutang/detail', ['as' => 'Simpan Pembayaran Hutang', 'uses' => 'TrxHutangController@simpanPembayaranHutang']);

  Route::get('/piutang', ['as' => 'Piutang', 'uses' => 'TrxPiutangController@listPiutang']);
  Route::get('/piutang/detail/{id}', ['as' => 'Detail Piutang', 'uses' => 'TrxPiutangController@detailPiutang']);
  Route::post('/piutang/detail', ['as' => 'Simpan Pembayaran Piutang', 'uses' => 'TrxPiutangController@simpanPembayaranPiutang']);
});

Route::get('/kas_harian', ['as' => 'Kas Harian', 'uses' => 'TrxKasHarianController@listKasHarian']);
Route::post('/kas_harian', ['as' => 'Save Kas Harian', 'uses' => 'TrxKasHarianController@saveKasHarian']);

Route::get('/laporan/arus-stok', ['as' => 'Laporan Arus Stok', 'uses' => 'LaporanController@arusStok']);
Route::get('/laporan/arus-stok/{type}', ['as' => 'Print Laporan Arus Stok', 'uses' => 'LaporanController@printArusStok']);

Route::group(['middleware' => ['auth', 'admin']], function () {
  Route::get('/laporan/hutang', ['as' => 'Laporan Hutang', 'uses' => 'LaporanController@hutang']);
  Route::get('/laporan/hutang/{type}', ['as' => 'Print Laporan Hutang', 'uses' => 'LaporanController@printHutang']);
  Route::get('/laporan/piutang', ['as' => 'Laporan Piutang', 'uses' => 'LaporanController@piutang']);
  Route::get('/laporan/piutang/{type}', ['as' => 'Print Laporan Piutang', 'uses' => 'LaporanController@printPiutang']);
  Route::get('/laporan/penjualan/rangkuman', ['as' => 'Laporan Penjualan Rangkuman', 'uses' => 'LaporanController@penjualanRangkuman']);
  Route::get('/laporan/penjualan/rangkuman/{type}', ['as' => 'Print Laporan Penjualan Rangkuman', 'uses' => 'LaporanController@printPenjualanRangkuman']);
  Route::get('/laporan/penjualan/per-customer', ['as' => 'Laporan Penjualan Per Customer', 'uses' => 'LaporanController@penjualanPerCustomer']);
  Route::get('/laporan/penjualan/per-customer/{type}', ['as' => 'Print Laporan Penjualan Per Customer', 'uses' => 'LaporanController@printPenjualanPerCustomer']);
  Route::get('/laporan/pembelian/rangkuman', ['as' => 'Laporan Pembelian Rangkuman', 'uses' => 'LaporanController@pembelianRangkuman']);
  Route::get('/laporan/pembelian/rangkuman/{type}', ['as' => 'Print Laporan Pembelian Rangkuman', 'uses' => 'LaporanController@printPembelianRangkuman']);
  Route::get('/laporan/pembelian/per-supplier', ['as' => 'Laporan Pembelian Per Supplier', 'uses' => 'LaporanController@pembelianPerSupplier']);
  Route::get('/laporan/pembelian/per-supplier/{type}', ['as' => 'Print Laporan Pembelian Per Supplier', 'uses' => 'LaporanController@printPembelianPerSupplier']);
  Route::get('/laporan/keuangan/laba-rugi', ['as' => 'Laporan Laba Rugi', 'uses' => 'LaporanController@labaRugi']);
  Route::get('/laporan/keuangan/laba-rugi/{type}', ['as' => 'Print Laporan Laba Rugi', 'uses' => 'LaporanController@printLabaRugi']);

  Route::get('/setting', ['as' => 'Setting', 'uses' => 'SettingController@detailSetting']);
  Route::post('/setting', ['as' => 'Save Setting', 'uses' => 'SettingController@saveSetting']);
});
