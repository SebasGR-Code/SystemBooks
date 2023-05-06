<?php

use App\Http\Livewire\ShowBooks;
use App\Http\Livewire\ShowClients;
use App\Http\Livewire\ShowUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('home');
});

Route::group(['middleware' => 'auth'], function (){
    Route::get('/libros', ShowBooks::class)->name('books');
    Route::get('/usuarios', ShowClients::class)->name('clients');
    Route::get('/cuentas', ShowUsers::class)->name('users');
});

//Formularios Auth - register, reset, verify no los usaremos en este proyecto
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
