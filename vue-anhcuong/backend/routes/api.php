<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

Route::get('/product', [IndexController::class, 'index']);

Route::get('/product/{id}', [IndexController::class, 'productDetail']);

Route::post('/product', [IndexController::class, 'addProduct']);

Route::put('/product/{id}', [IndexController::class, 'update']);

Route::delete('/product/{id}', [IndexController::class, 'destroy']);