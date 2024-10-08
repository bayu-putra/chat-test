<?php

use App\Http\Controllers\SendMessageController;
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
});

Route::controller(SendMessageController::class)->group(function () {
    Route::get('messanger/{id}', 'show_room');

    //send message 
    Route::post("/send",'sendMessage');

    //read_messages 
    Route::post("/read_all",'read_all_messages');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
