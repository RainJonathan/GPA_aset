<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\AssetController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

//routes penyewa
Route::get('/hosts', [HostController::class, 'index'])->name('host.index');
Route::get('/hosts/create/{asset}', [HostController::class, 'create'])->name('host.create');
Route::post('/hosts/{asset}', [HostController::class, 'store'])->name('host.store');
Route::get('/hosts/{host}', [HostController::class, 'show'])->name('host.show');
Route::get('/hosts/{host}/edit', [HostController::class, 'edit'])->name('host.edit');
Route::put('/hosts/{host}', [HostController::class, 'update'])->name('host.update');
Route::delete('/hosts/{host}', [HostController::class, 'destroy'])->name('host.destroy');

//routes aset
Route::get('/assets', [AssetController::class, 'index'])->name('asset.index');
Route::get('/assets/create', [AssetController::class, 'create'])->name('asset.create');
Route::get('/assets/earning', [AssetController::class,'earning'])->name('asset.earning');
Route::get('/assets/export', [AssetController::class, 'export'])->name('asset.export');
Route::get('/asset/export-details', [AssetController::class, 'exportDetails'])->name('asset.exportDetails');
Route::post('/assets', [AssetController::class, 'store'])->name('asset.store');
Route::get('/assets/{asset}', [AssetController::class, 'show'])->name('asset.show');
Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])->name('asset.edit');
Route::put('/assets/{asset}', [AssetController::class, 'update'])->name('asset.update');
Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])->name('asset.destroy');
Route::get('/assets/{asset}', [AssetController::class, 'details'])->name('asset.details');
Route::get('/assets/{asset}/edited', [AssetController::class, 'edited'])->name('asset.edited');