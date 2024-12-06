<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BudgetController;
use Illuminate\Support\Facades\Route;

// Public routes (guest middleware)
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('account.login');
    Route::post('/login/authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
    Route::get('/register', [LoginController::class, 'register'])->name('account.register');
    Route::post('/register/process', [LoginController::class, 'processRegister'])->name('account.processRegister');
});

// Protected routes (auth middleware)
Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('account.logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Budget routes
    // Route::get('/budgets', [DashboardController::class, 'index'])->name('budgets.index');
    // Route::post('/budgets/store', [DashboardController::class, 'storeBudget'])->name('budgets.store');
    // Route::post('/budgets/expenses', [DashboardController::class, 'storeExpense'])->name('expenses.store');
    // Route::delete('/expenses', [DashboardController::class, 'deleteExpense'])->name('expenses.delete');
    // Route::get('/budgets', [DashboardController::class, 'index'])->name('budgets.index');
    Route::delete('/budgets/{id}', [DashboardController::class, 'destroy'])->name('budgets.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/budgets/store', [DashboardController::class, 'storeBudget'])->name('budgets.store');
    Route::post('/budgets/{budgetId}/expenses', [DashboardController::class, 'storeExpense'])->name('expenses.store');
    Route::delete('/expenses/{expenseId}', [DashboardController::class, 'deleteExpense'])->name('expenses.delete');
});
