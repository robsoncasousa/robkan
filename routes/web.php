<?php

use App\Http\Controllers\Api\ExportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('/export', [ExportController::class, 'dump'])->name('export_sql');
Route::get('/export-download/{file}', function ($file) {
    return Storage::download("public/dumps/" . $file);
})->name('export.download');

Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');
