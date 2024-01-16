<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    //category
    Route::get('/category', [CategoryController::class, 'Index'])->name('category');
    Route::get('/tambah-category', [CategoryController::class, 'Tambah'])->name('tambahcategory');
    Route::post('/send-category', [CategoryController::class, 'Send'])->name('Send-category');
    Route::get('/edit-category/{id}', [CategoryController::class, 'Edit'])->name('edit-category');
    Route::post('/update-category/{id}', [CategoryController::class, 'Update'])->name('update-category');
    Route::DELETE('/delete-category/{id}', [CategoryController::class, 'Delete'])->name('delete-category');

    //item
    Route::get('/item', [ItemController::class, 'Index'])->name('item');
    Route::get('/tambah-item', [ItemController::class, 'Tambah'])->name('tambahitem');
    Route::post('/send-item', [ItemController::class, 'Send'])->name('Send-item');
    Route::get('/edit-item/{id}', [ItemController::class, 'Edit'])->name('edit-item');
    Route::post('/update-item/{id}', [ItemController::class, 'Update'])->name('update-item');
    Route::DELETE('/delete-item/{id}', [ItemController::class, 'Delete'])->name('delete-item');

    //transaction
    Route::get('/transaction', [TransactionController::class, 'Index'])->name('transaction');
    Route::get('/tambah-transaction/{id}', [TransactionController::class, 'Tambah'])->name('tambahtransaction');
    Route::post('/send-transaction', [TransactionController::class, 'Send'])->name('Send-transaction');
    Route::get('/edit-transaction/{id}', [TransactionController::class, 'Edit'])->name('edit-transaction');
    Route::post('/update-transaction', [TransactionController::class, 'Update'])->name('update-transaction');
    Route::get('/delete-transaction/{id}', [TransactionController::class, 'Delete'])->name('delete-transaction');
    Route::post('/transaction-store', [TransactionController::class, 'store'])->name('transaction.store');
});
