<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/test', function () {
    return Inertia::render('newPage');
})->middleware(['auth', 'verified'])->name('Test');

Route::get('/newProduct', function () {
    return Inertia::render('Dashboard/newProduct');
})->middleware(['auth', 'verified'])->name('NewProduct');


Route::get('/allproducts', [ProductController::class, 'index'])->name('products');
Route::get('/product/{product}', [ProductController::class, 'edit'])->name('productEdit');
Route::post('/saveProduct', [ProductController::class, 'store'])->name('productSave');
Route::post('/product/{product}', [ProductController::class, 'update'])->name('productUpdate');
Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

Route::get('/outStocks', [StockController::class, 'outStock'])->name('outStocks');
Route::get('/stocks', [StockController::class, 'stocks'])->name('stocks');
Route::get('/addStock', [StockController::class, 'addStockTable'])->name('addStockTable');
Route::post('/saveStock', [StockController::class, 'saveStock'])->name('saveStocks');
Route::get('/updateStock', [StockController::class, 'updateStockTable'])->name('updateTable');
Route::post('/saveUpdate', [StockController::class, 'saveUpdate'])->name('stocks.saveUpdates');
Route::get('/stocksReport', [StockController::class, 'stockReport'])->name('stocksReport');
Route::get('/stockByBatch/{batch}', [StockController::class, 'stockReportByBatch'])->name('stocksByBatch');
Route::get('/empties', [ProductController::class, 'empties'])->name('stocksEmpties');
Route::get('/newEmpties', [ProductController::class, 'newEmpties'])->name('newEmpties');
Route::post('/newEmpties', [ProductController::class, 'saveEmpties'])->name('saveNewEmpties');
Route::delete('/stocks/delete/{batch}', [StockController::class, 'destroy'])->name('stocksDestroy');
Route::get('/stocks/edit/{batch}', [StockController::class, 'stockBatchEdit'])->name('stocks.edit');
Route::post('/stocks/edit/{batch}', [StockController::class, 'saveEdit'])->name('stocks.updateOne');

Route::get('/salesReport', [StockController::class, 'salesReport'])->name('salesReport');
Route::get('/salesReport/{date}', [StockController::class, 'salesReportByDate'])->name('salesReportByDate');
Route::get('/salesReportByProduct', [StockController::class, 'salesReportByProduct'])->name('salesReportByProduct');
Route::post('/salesReportByProduct', [StockController::class, 'salesReportByRange'])->name('salesReportByRange');

Route::delete('/sales/delete/{date}', [StockController::class, 'deleteSale'])->name('deleteSale');