<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\TransactionController;
use App\Models\Product;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/export-pdf', [UserController::class, 'exportPdf'])->name('users.exportPdf');
Route::get('/users/exportCsv', [UserController::class, 'exportCsv'])->name('users.exportCsv');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/export-pdf', [ProductController::class, 'exportPDF'])->name('products.export-pdf');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
Route::get('/auctions/create', [AuctionController::class, 'create'])->name('auctions.create');
Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
Route::get('/auctions/export-pdf', [AuctionController::class, 'exportPdf'])->name('auctions.export-pdf');
Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
Route::get('/auctions/{auction}/edit', [AuctionController::class, 'edit'])->name('auctions.edit');
Route::put('/auctions/{auction}', [AuctionController::class, 'update'])->name('auctions.update');
Route::delete('/auctions/{auction}', [AuctionController::class, 'destroy'])->name('auctions.destroy');
Route::post('auctions/{auction}/select-winner', [AuctionController::class, 'selectWinner'])->name('auctions.selectWinner');

Route::middleware('auth')->group(function () {
    Route::prefix('auctions/{auction}/bids')->group(function () {
        Route::get('/', [BidController::class, 'index'])->name('bids.index');
        Route::get('/create', [BidController::class, 'create'])->name('bids.create');
        Route::post('/', [BidController::class, 'store'])->name('bids.store');
        Route::get('/export-pdf', [BidController::class, 'exportPdf'])->name('bids.export-pdf');
        Route::get('/{bid}', [BidController::class, 'show'])->name('bids.show');
        Route::get('/{bid}/edit', [BidController::class, 'edit'])->name('bids.edit');
        Route::put('/{bid}', [BidController::class, 'update'])->name('bids.update');
        Route::delete('/{bid}', [BidController::class, 'destroy'])->name('bids.destroy');
        
    });
});

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/export-pdf', [TransactionController::class, 'exportPdf'])->name('transactions.export-pdf');
Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

Route::prefix('feedbacks')->group(function () {
    Route::get('/', [FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::get('create', [FeedbackController::class, 'create'])->name('feedbacks.create');
    Route::post('store', [FeedbackController::class, 'store'])->name('feedbacks.store');
    Route::get('export-pdf', [FeedbackController::class, 'exportPdf'])->name('feedbacks.export-pdf');
    Route::get('{id}/edit', [FeedbackController::class, 'edit'])->name('feedbacks.edit');
    Route::put('{id}', [FeedbackController::class, 'update'])->name('feedbacks.update');
    Route::delete('{id}', [FeedbackController::class, 'destroy'])->name('feedbacks.destroy');
    Route::get('{id}', [FeedbackController::class, 'show'])->name('feedbacks.show');
});

Route::get('/transactions/export/csv', [TransactionController::class, 'exportCsv'])->name('transactions.export-csv');


Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');