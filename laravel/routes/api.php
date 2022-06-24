<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

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

Route::post('/', [SessionController::class, 'session']);
Route::get('/get/{sessionID}', [SessionController::class, 'getSession']);
// Route::post('/update', [SessionController::class, 'updateScenario']);

// Route::get('/{sessionToken}', [SessionController::class, 'index']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function() {
    Route::post('/update', [SessionController::class, 'updateScenario']);
    Route::get('/{sessionToken}', [SessionController::class, 'index']);
    Route::post('/logout', [SessionController::class, 'sessionLogout']);
});

// Route::group(['middleware' => ['auth:sanctum']], function() {
//     Route::post('/update', [SessionController::class, 'updateScenario']);
//     Route::get('/{sessionToken}', [SessionController::class, 'index']);
//     Route::post('/logout', [SessionController::class, 'sessionLogout']);
// });