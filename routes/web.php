<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\RootController::class, 'renderHomePage'])->name('root.home-index');

Route::get('/signin', [App\Http\Controllers\AuthController::class, 'renderSignin'])->name('auth.render-signin');
Route::post('/signin', [App\Http\Controllers\AuthController::class, 'handleSignin'])->name('auth.handle-signin');


Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'handleLogout'])->name('auth.handle-logout');
    // GLOBAL MENU AUTHENTIKASI
    Route::get('/dashboard', [App\Http\Controllers\Private\User\RootController::class, 'renderDashboard'])->name('dashboard-index');
    Route::get('/profile', [App\Http\Controllers\Private\User\RootController::class, 'renderProfile'])->name('profile-index');
    Route::post('/profile', [App\Http\Controllers\Private\User\RootController::class, 'handleProfile'])->name('profile-update');
    Route::delete('/profile/pendidikan/{id}', [App\Http\Controllers\Private\User\RootController::class, 'deletePendidikan'])->name('profile.delete-pendidikan');
    Route::delete('/profile/keluarga/{id}', [App\Http\Controllers\Private\User\RootController::class, 'deleteKeluarga'])->name('profile.delete-keluarga');
    
    // Master Data Referensi
    Route::get('/referensi/agama', [App\Http\Controllers\Referensi\AgamaController::class, 'index'])->name('referensi.agama-index');
    Route::get('/referensi/agama/trashed', [App\Http\Controllers\Referensi\AgamaController::class, 'trash'])->name('referensi.agama-trash');
    Route::post('/referensi/agama', [App\Http\Controllers\Referensi\AgamaController::class, 'store'])->name('referensi.agama-store');
    Route::patch('/referensi/agama/{id}/update', [App\Http\Controllers\Referensi\AgamaController::class, 'update'])->name('referensi.agama-update');
    Route::delete('/referensi/agama/{id}/delete', [App\Http\Controllers\Referensi\AgamaController::class, 'destroy'])->name('referensi.agama-destroy');
    Route::post('/referensi/agama/{id}/restore', [App\Http\Controllers\Referensi\AgamaController::class, 'restore'])->name('referensi.agama-restore');
    
});

// Route::group(['prefix' => 'superuser', 'middleware' => ['auth:web','role:Super Admin'], 'as' => 'super.'],function(){

//     // Global Route
//     require __DIR__.'/basic-routes.php';

//     // Master Authority
//     require __DIR__.'/master-routes.php';

// });