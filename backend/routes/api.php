<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AffiliateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('cadastroafiliado', [AffiliateController::class, 'store']);
Route::get('affiliates', [AffiliateController::class, 'index']);
Route::get('affiliates/{id}', [AffiliateController::class, 'show']);