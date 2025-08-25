<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\RootController::class, 'renderHomePage'])->name('root.home-index');

Route::get('/signin', [App\Http\Controllers\AuthController::class, 'renderSignin'])->name('auth.render-signin');
Route::post('/signin', [App\Http\Controllers\AuthController::class, 'handleSignin'])->name('auth.handle-signin');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'handleLogout'])->name('auth.handle-logout');


Route::middleware(['auth'])->group(function () {
    // GLOBAL MENU AUTHENTIKASI
    Route::get('/dashboard', [App\Http\Controllers\Private\User\RootController::class, 'renderDashboard'])->name('dashboard-render');
    Route::get('/profile', [App\Http\Controllers\Private\User\RootController::class, 'renderProfile'])->name('profile-render');
    Route::post('/profile', [App\Http\Controllers\Private\User\RootController::class, 'handleProfile'])->name('profile-handle');
    Route::delete('/profile/pendidikan/{id}', [App\Http\Controllers\Private\User\RootController::class, 'deletePendidikan'])->name('profile.delete-pendidikan');
    Route::delete('/profile/keluarga/{id}', [App\Http\Controllers\Private\User\RootController::class, 'deleteKeluarga'])->name('profile.delete-keluarga');
});

// Route::group(['prefix' => 'superuser', 'middleware' => ['auth:web','role:Super Admin'], 'as' => 'super.'],function(){

//     // Global Route
//     require __DIR__.'/basic-routes.php';

//     // Master Authority
//     require __DIR__.'/master-routes.php';

// });