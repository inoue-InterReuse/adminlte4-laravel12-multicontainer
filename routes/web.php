<?php

use App\Http\Controllers\UserListController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


Route::middleware(['web'])->group(function () {

  Route::get('/', function () {
    return view('dashboard');
  })->middleware(['auth', 'verified'])->name('dashboard');

  Route::controller(UserListController::class)->group(function () {
    Route::get('/settings/user-list', 'index')->name('user-list');
    Route::post('/settings/user-list/update-create', 'updateToCreate')->name('user-list.updateToCreate');
    Route::post('/settings/user-list/detail', 'detail')->name('user-list.detail');
    Route::post('/settings/user-list/get-data', 'getData')->name('user-list.getData');
  });

  require __DIR__ . '/auth.php';
});
