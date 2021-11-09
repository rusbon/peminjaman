<?php

use Illuminate\Support\Facades\Route;

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

Route::get('inventory', 'InventoryController@index');
Route::post('inventory/submit', 'InventoryController@submit');
Route::post('inventory/search', 'InventoryController@search');
Route::post('inventory/searchId', 'InventoryController@searchId');

Route::get('peminjaman', 'LoaningController@index');
Route::post('peminjaman/submit', 'LoaningController@submit');
