<?php

// routes/web.php
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\GalleryController;

use App\Http\Controllers\Admin\TemplateCategoriesController;
use App\Http\Controllers\Admin\TemplateCategoryController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\BookingController;
use Illuminate\Support\Facades\Route;

// User Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/check-queue', [App\Http\Controllers\GuestController::class, 'checkQueue'])->name('check-queue');
Route::post('/check-queue', [App\Http\Controllers\GuestController::class, 'searchQueue'])->name('search-queue');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/templates', [HomeController::class, 'templates'])->name('templates');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/schedules', [HomeController::class, 'schedules'])->name('schedules');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// User Booking Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/my-bookings/history', [BookingController::class, 'history'])->name('bookings.history');
    Route::get('/booking/{booking}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{booking}', [BookingController::class, 'update'])->name('booking.update');

    // API Routes (Session Auth)
    Route::post('/api/check-promo', [App\Http\Controllers\Api\PromoCheckController::class, 'check'])->name('api.check-promo');
});



// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:admin'])->group(function () {
        // Services Management
        Route::resource('services', ServiceController::class);

        // Schedules Management
        Route::resource('schedules', ScheduleController::class);

        // Bookings Management
        Route::get('/bookings/history', [AdminBookingController::class, 'history'])->name('bookings.history');
        Route::resource('bookings', AdminBookingController::class);
        Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
        Route::post('/bookings/reorder', [AdminBookingController::class, 'reorder'])->name('bookings.reorder');
        Route::post('/bookings/{booking}/move-to-top', [AdminBookingController::class, 'moveToTop'])->name('bookings.move-to-top');
        Route::post('/bookings/{booking}/send-result', [AdminBookingController::class, 'sendResult'])->name('bookings.send-result');

        // New CRUD Management
        Route::resource('items', App\Http\Controllers\Admin\ItemController::class);
        Route::resource('service-addons', App\Http\Controllers\Admin\ServiceAddonController::class);
        Route::resource('promos', App\Http\Controllers\Admin\PromoController::class);
        Route::resource('settings', App\Http\Controllers\Admin\SettingController::class)->only(['index', 'store']);

        // Finance Management
        Route::get('/finance', [App\Http\Controllers\Admin\FinanceController::class, 'index'])->name('finance.index');
        Route::post('/finance', [App\Http\Controllers\Admin\FinanceController::class, 'store'])->name('finance.store');
        Route::put('/finance/{transaction}', [App\Http\Controllers\Admin\FinanceController::class, 'update'])->name('finance.update');
        Route::delete('/finance/{transaction}', [App\Http\Controllers\Admin\FinanceController::class, 'destroy'])->name('finance.destroy');
        Route::get('/finance/history', [App\Http\Controllers\Admin\FinanceController::class, 'history'])->name('finance.history');
        Route::get('/finance/analysis', [App\Http\Controllers\Admin\FinanceController::class, 'analysis'])->name('finance.analysis');
        Route::get('/finance/export-pdf', [App\Http\Controllers\Admin\FinanceController::class, 'exportPdf'])->name('finance.export-pdf');
    });

    // Gallery Management

    // Gallery Management
    Route::resource('galleries', GalleryController::class);

    // Template Management
    Route::resource('templates', TemplateController::class);
    Route::resource(
        'template-categories',
        TemplateCategoryController::class
    );

    // New CRUD Management
    Route::resource('items', App\Http\Controllers\Admin\ItemController::class);
    Route::resource('service-addons', App\Http\Controllers\Admin\ServiceAddonController::class);
    Route::resource('promos', App\Http\Controllers\Admin\PromoController::class);
    Route::resource('settings', App\Http\Controllers\Admin\SettingController::class)->only(['index', 'store']);

    // Finance Management
    Route::get('/finance', [App\Http\Controllers\Admin\FinanceController::class, 'index'])->name('finance.index');
    Route::post('/finance', [App\Http\Controllers\Admin\FinanceController::class, 'store'])->name('finance.store');
    Route::put('/finance/{transaction}', [App\Http\Controllers\Admin\FinanceController::class, 'update'])->name('finance.update');
    Route::delete('/finance/{transaction}', [App\Http\Controllers\Admin\FinanceController::class, 'destroy'])->name('finance.destroy');
    Route::get('/finance/history', [App\Http\Controllers\Admin\FinanceController::class, 'history'])->name('finance.history');
    Route::get('/finance/analysis', [App\Http\Controllers\Admin\FinanceController::class, 'analysis'])->name('finance.analysis');
    Route::get('/finance/export-pdf', [App\Http\Controllers\Admin\FinanceController::class, 'exportPdf'])->name('finance.export-pdf');

    // Account Management
    Route::resource('accounts', App\Http\Controllers\Admin\AccountController::class)->except(['create', 'store', 'show']);
});

// User Dashboard & Profile
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Google Authentication Routes
// Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
// Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

require __DIR__ . '/auth.php';



