<?php
use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('register', [Controllers\AuthController::class, 'registerUser']);
Route::post('login', [Controllers\AuthController::class, 'loginUser']);

Route::group([

    'middleware' => 'auth:sanctum',
    'prefix' => 'auth'

], function ($router) {

    Route::post('me', [Controllers\AuthController::class, 'me']);


});
