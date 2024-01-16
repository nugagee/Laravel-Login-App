<?php

use App\Http\Controllers\AuthManager;
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

Route::get('/', function () {
    return view('welcome');
})->name('home');

// LOGIN FUNCTION HAS BEEN CREATED IN THE CONTROLLER - Calling the Controller function here
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');

Route::get('/register', [AuthManager::class, 'register'])->name('register');
Route::post('/register', [AuthManager::class, 'registerPost'])->name('register.post');

Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

// WHENEVER YOU NEED A ROUTE THAT NEEDS TO BE ACCESS ONLY BY A LOGGED IN USER, IT SHOULD BE INSIDE THE ROUTEGROUP
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', function () {
        return "Hi welcome to your profile page";
    })->name('profile');
});

