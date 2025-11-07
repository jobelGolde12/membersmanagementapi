<?php

use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('members')->group(function () {
    Route::get('/', [MemberController::class, 'index']);
    Route::get('/{id}', [MemberController::class, 'show']);
    Route::post('/', [MemberController::class, 'store']);
    Route::put('/{id}', [MemberController::class, 'update']);
    Route::delete('/{id}', [MemberController::class, 'destroy']);

    // Filter routes
    Route::get('/seniors', [MemberController::class, 'seniors']);
    Route::get('/minors', [MemberController::class, 'minors']);
    Route::get('/active', [MemberController::class, 'active']);
    Route::get('/inactive', [MemberController::class, 'inactive']);
    Route::get('/male', [MemberController::class, 'male']);
    Route::get('/female', [MemberController::class, 'female']);
    Route::get('/purok/{purok}', [MemberController::class, 'purok']);
    Route::get('/search', [MemberController::class, 'search']);

    // Analytics
    Route::get('/statistics', [MemberController::class, 'statistics']);
    Route::get('/age-distribution', [MemberController::class, 'ageDistribution']);
});