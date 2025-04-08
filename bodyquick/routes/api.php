<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/prueba', function () {
    return response()->json(['mensaje' => '¡Laravel y React están conectados!']);
});
Route::post('/admin/create-user', [AdminController::class, 'createUser']);