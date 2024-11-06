<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MenuController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//localhost:8000/api/v1/menu
Route::prefix('v1')->group(function () {
    Route::get('/menu', [MenuController::class, 'index']);
});

Route::prefix('v2')->group(function () {
    Route::get('/menu', [MenuController::class, 'getMenu']);
});
