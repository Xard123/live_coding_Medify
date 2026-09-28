<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index']);
Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search']);
Route::get('/master-items/excel', [App\Http\Controllers\MasterItemsController::class, 'excel']);
Route::get('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formSubmit']);
Route::get('/master-items/view/{kode}', [App\Http\Controllers\MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [App\Http\Controllers\MasterItemsController::class, 'delete']);
Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);

Route::get('/kategori-items', [App\Http\Controllers\KategoriItemsController::class, 'index']);
Route::get('/kategori-items/search', [App\Http\Controllers\KategoriItemsController::class, 'search']);
Route::get('/kategori-items/form/{method}/{id?}', [App\Http\Controllers\KategoriItemsController::class, 'formView']);
Route::post('/kategori-items/form/{method}/{id?}', [App\Http\Controllers\KategoriItemsController::class, 'formSubmit']);
Route::get('/kategori-items/view/{id}', [App\Http\Controllers\KategoriItemsController::class, 'singleView']);
Route::get('/kategori-items/delete/{id}', [App\Http\Controllers\KategoriItemsController::class, 'delete']);
Route::get('/kategori-items/pdf/{id}', [App\Http\Controllers\KategoriItemsController::class, 'pdf']);
