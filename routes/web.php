<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FactoryOnboardingController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FactoryDashboardController;
use App\Http\Controllers\FactoryProductController;
use App\Http\Controllers\FactoryProfileController;
use App\Http\Controllers\FactoryStorefrontController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/factories/register', [FactoryOnboardingController::class, 'create']);
Route::post('/factories', [FactoryOnboardingController::class, 'store']);
Route::get('/factories/thank-you', function () {
    return view('factories.thank-you');
})->name('factories.thankyou');

Route::get('/marketplace/factories', [MarketplaceController::class, 'factories']);
Route::get('/marketplace/products', [MarketplaceController::class, 'products']);

Route::post('/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');

Route::get('/f/{factory:slug}', [FactoryStorefrontController::class, 'show'])
    ->name('storefront.show');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [FactoryDashboardController::class, 'index'])
    ->middleware(['auth', 'factory'])
    ->name('dashboard');

Route::middleware(['auth', 'factory'])->group(function () {
    Route::get('/dashboard/profile', [FactoryProfileController::class, 'edit'])
        ->name('factory.profile.edit');
    Route::put('/dashboard/profile', [FactoryProfileController::class, 'update'])
        ->name('factory.profile.update');

    Route::get('/dashboard/products', [FactoryProductController::class, 'index'])
        ->name('factory.products.index');
    Route::get('/dashboard/products/create', [FactoryProductController::class, 'create'])
        ->name('factory.products.create');
    Route::post('/dashboard/products', [FactoryProductController::class, 'store'])
        ->name('factory.products.store');
    Route::get('/dashboard/products/{product}/edit', [FactoryProductController::class, 'edit'])
        ->name('factory.products.edit');
    Route::put('/dashboard/products/{product}', [FactoryProductController::class, 'update'])
        ->name('factory.products.update');
});
