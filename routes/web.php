<?php

use App\Http\Controllers\AdminPanel;
use App\Http\Controllers\tgBotController;
use App\Http\Controllers\WelcomeController;
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

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/adminpanel', [AdminPanel::class, 'index'])->name('adminpanel');


Route::get('/bott', [tgBotController::class, 'index']);
Route::post('/bot_hook', [tgBotController::class, 'bot_hook']);
Route::get('/change_city/{city}', [WelcomeController::class, 'change_city']);
Route::post('/crud/update_group_info/{id}', [AdminPanel::class, 'update']);
Route::post('/system_test', [AdminPanel::class, 'system_test']);

Route::get('/newsletter/{token}', [AdminPanel::class, 'newsletter']);

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
