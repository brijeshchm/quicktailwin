<?php

use App\Http\Controllers\Sales\VendorController;


Route::get('/logout',[App\Http\Controllers\Auth\AuthSalesController::class,'logout']);
Route::get('/dashboard',[App\Http\Controllers\Sales\DashboardController::class, 'index'])->name('dashboard');


  Route::get('/vendors/export', [VendorController::class, 'export'])->name('vendors.export');
    Route::patch('/vendors/{vendor}/status', [VendorController::class, 'toggleStatus'])
        ->name('vendors.status');
    Route::resource('vendors', VendorController::class)->except(['show']);


Route::get('/dashboard/get-paid-client', [App\Http\Controllers\DashboardController::class, 'getPaidClients']);	
 