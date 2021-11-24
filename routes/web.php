<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ban_tin;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::get('/', [ban_tin::class, 'show'])->middleware('auth')->name('/');

// Route::get('/ban_tin',function(){
//     return view('ban_tin');
// });
require __DIR__.'/auth.php';
