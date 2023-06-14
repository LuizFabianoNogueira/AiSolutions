<?php

use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inport', [ImportController::class, 'import'])->name('import');
Route::post('/inport/addDocument', [ImportController::class, 'addDocument'])->name('addDocument');
Route::post('/inport/addDocumentJob', [ImportController::class, 'addDocumentJob'])->name('addDocumentJob');
