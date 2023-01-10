<?php

use App\Http\Controllers\Api\CardsController;
use App\Http\Controllers\Api\ColumnsController;
use Illuminate\Support\Facades\Route;

Route::resource('cards', CardsController::class)->only(['store', 'index']);
Route::resource('columns', ColumnsController::class)->only('store', 'update', 'destroy', 'index');
Route::post('columns/update-order', [ColumnsController::class, 'updateOrder']);
