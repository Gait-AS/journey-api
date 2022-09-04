<?php

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

Route::get('/login', function () {
    return response()->json([
        'status' => false,
        'message' => 'User need to login',
        'data' => []
    ], 401);
})->name('login');


Route::get('/', function (Request $request) {
    return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => []
    ], 200);
});
