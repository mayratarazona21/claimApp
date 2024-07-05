<?php

use Illuminate\Support\Facades\Route;
use Hashids\Hashids;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\administration\UserManagement;
use App\Http\Controllers\administration\RolesController;
use App\Http\Controllers\LogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main Page Route
//Route::get('/', [HomePage::class, 'index'])->name('pages-home');
Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

// locale
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// pages
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
  /*Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');*/
  Route::get('/', [HomePage::class, 'index'])->name('pages-home');
  Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');

  Route::get('/administration/users', [UserManagement::class, 'UserManagement'])->name('users');
  Route::resource('/user', UserManagement::class);

  Route::get('/administration/roles', [RolesController::class, 'index'])->name('roles');
  Route::resource('rol', RolesController::class);
  Route::get('/roles/{encrypted_id}/edit', [RolesController::class, 'edit'])->name('roles.edit');

  Route::get('/administration/log-access', [LogController::class, 'showLogAccess'])->name(
    'administration.log.log-access'
  );
  Route::get('/administration/log-actions', [LogController::class, 'showLogActions'])->name(
    'administration.log.log-actions'
  );
  Route::get('/administration/log-details/{id}', [LogController::class, 'show'])->name(
    'administration.log.log-details'
  );

  // Route::resource('/administration/roles', RolesController::class)->name('roles');
  //Route::post('/menu-list', [RolesController::class, 'menuList']);
  //Route::resource('/roles', 'RolesController')->middleware('auth');
});
