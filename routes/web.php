<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DailyLegderController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\StockController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});




Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [StockController::class, 'index'])->name('dashboard');


    Route::get('/user', function (Request $request) {
        return response()->json(['user' => Auth::guard()]);
    })->name('profile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/incomes', [IncomeController::class, 'index'])->name('incomeTable');
    Route::patch('/income/edit', [IncomeController::class, 'update'])->name('income.edit');
    Route::post('/income', [IncomeController::class, 'store'])->name('income.store');
    Route::delete('/income', [IncomeController::class, 'delete'])->name('income.delete');

    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expensesTable');
    Route::post('/expense', [ExpenseController::class, 'store'])->name('expense.store');
    Route::patch('/expense/{expense}', [ExpenseController::class, 'update'])->name('expense.update');
    Route::delete('/expense/{expense}', [ExpenseController::class, 'delete'])->name('expense.delete');

    Route::get('/cashflow', [ProfitController::class, 'index'])->name('cashflow');
    Route::post('/cashflow/range', [ProfitController::class, 'byRange'])->name('cashflow.byRange');
    Route::get('/cashflow/{filter}', [ProfitController::class, 'filtered'])->name('cashflow.filter');

    Route::get('/company', [CompanyController::class, 'company'])->name('company');
    Route::patch('/company/{company}', [CompanyController::class, 'update'])->name('company.update');
    Route::post('/company', [CompanyController::class, 'store'])->name('company.new');
    Route::get('/companies', [CompanyController::class, 'index'])->name('all_companies');

    Route::post('/open_register', [DailyLegderController::class, 'open'])->name('open_ledger');
    Route::post('/close_register', [DailyLegderController::class, 'close'])->name('close_ledger');
    Route::post('/company/legder', [DailyLegderController::class, 'index'])->name('company_ledger');

    require __DIR__ . '/testroute.php';
});

require __DIR__ . '/auth.php';
