<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\CustomerOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ============================================================
    // PRODUCT CATALOG — Admin, Data Analyst, Customer
    // ============================================================
    Route::middleware('role:admin,data_analyst,customer')->group(function () {
        Route::get('/products', [ProductCatalogController::class, 'index'])->name('products.index');
        Route::get('/products/{skuId}', [ProductCatalogController::class, 'show'])->name('products.show');
    });

    // ============================================================
    // CUSTOMER ORDER — Customer only (+ Admin)
    // ============================================================
    Route::middleware('role:admin,customer')->group(function () {
        Route::get('/orders/my', [CustomerOrderController::class, 'myOrders'])->name('orders.my');
        Route::get('/orders/create', [CustomerOrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [CustomerOrderController::class, 'store'])->name('orders.store');
    });

    // ============================================================
    // CUSTOMER DATA MANAGEMENT — Admin (full CRUD), Data Analyst (read)
    // ============================================================
    // Write operations — Admin only (MUST be before {id} wildcard)
    Route::middleware('role:admin')->group(function () {
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });

    // Read operations — Admin and Data Analyst
    Route::middleware('role:admin,data_analyst')->group(function () {
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
    });

    // ============================================================
    // TRANSACTIONS — Admin and Data Analyst (view all)
    // ============================================================
    Route::middleware('role:admin,data_analyst')->group(function () {
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    });

    // ============================================================
    // AUDIT LOGS — Admin and Auditor
    // ============================================================
    Route::middleware('role:admin,auditor')->group(function () {
        Route::get('/audit', [AuditLogController::class, 'index'])->name('audit.index');
        Route::get('/audit/{auditLog}', [AuditLogController::class, 'show'])->name('audit.show');
    });
});
