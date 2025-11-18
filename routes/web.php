<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FactoryOnboardingController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BuyerAuthController;
use App\Http\Controllers\BuyerDashboardController;
use App\Http\Controllers\BuyerOrderController;
use App\Http\Controllers\FactoryOrderController;
use App\Http\Controllers\FactoryDashboardController;
use App\Http\Controllers\FactoryInquiryController;
use App\Http\Controllers\FactoryProductController;
use App\Http\Controllers\FactoryProfileController;
use App\Http\Controllers\FactoryStorefrontController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminFactoryController;
use App\Http\Controllers\AdminIndustryController;
use App\Http\Controllers\AdminProductCategoryController;
use App\Http\Controllers\AdminZoneController;

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
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

Route::get('/f/{factory:slug}', [FactoryStorefrontController::class, 'show'])
    ->name('storefront.show');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/buyer/register', [BuyerAuthController::class, 'showRegisterForm'])->name('buyer.register');
Route::post('/buyer/register', [BuyerAuthController::class, 'register'])->name('buyer.register.store');

Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->group(function () {
    Route::get('/dashboard', [BuyerDashboardController::class, 'index'])
        ->name('buyer.dashboard');
    Route::get('/orders', [BuyerOrderController::class, 'index'])
        ->name('buyer.orders.index');
});

Route::get('/dashboard', [FactoryDashboardController::class, 'index'])
    ->middleware(['auth', 'factory'])
    ->name('dashboard');

Route::middleware(['auth', 'factory', 'role:factory_owner,super_admin'])->group(function () {
    Route::get('/dashboard/profile', [FactoryProfileController::class, 'edit'])
        ->name('factory.profile.edit');
    Route::put('/dashboard/profile', [FactoryProfileController::class, 'update'])
        ->name('factory.profile.update');
});

Route::middleware(['auth', 'factory'])->group(function () {
    Route::get('/dashboard/products', [FactoryProductController::class, 'index'])
        ->name('factory.products.index');
    Route::get('/dashboard/products/create', [ProductController::class, 'create'])
        ->name('factory.products.create');
    Route::post('/dashboard/products', [ProductController::class, 'store'])
        ->name('factory.products.store');
    Route::get('/dashboard/products/{product}/edit', [FactoryProductController::class, 'edit'])
        ->name('factory.products.edit');
    Route::put('/dashboard/products/{product}', [FactoryProductController::class, 'update'])
        ->name('factory.products.update');

    Route::get('/dashboard/inquiries', [FactoryInquiryController::class, 'index'])
        ->name('factory.inquiries.index');
    Route::put('/dashboard/inquiries/{inquiry}', [FactoryInquiryController::class, 'updateStatus'])
        ->name('factory.inquiries.update-status');

    Route::get('/dashboard/orders', [FactoryOrderController::class, 'index'])
        ->name('factory.orders.index');
    Route::put('/dashboard/orders/{order}', [FactoryOrderController::class, 'updateStatus'])
        ->name('factory.orders.update-status');

});

Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->group(function () {
    Route::get('/', AdminDashboardController::class)
        ->name('admin.dashboard');
    Route::get('/factories', [AdminFactoryController::class, 'index'])
        ->name('admin.factories.index');
    Route::put('/factories/{factory}/status', [AdminFactoryController::class, 'updateStatus'])
        ->name('admin.factories.update-status');

    Route::get('/zones', [AdminZoneController::class, 'index'])
        ->name('admin.zones.index');
    Route::post('/zones', [AdminZoneController::class, 'store'])
        ->name('admin.zones.store');
    Route::put('/zones/{zone}', [AdminZoneController::class, 'update'])
        ->name('admin.zones.update');
    Route::delete('/zones/{zone}', [AdminZoneController::class, 'destroy'])
        ->name('admin.zones.destroy');

    Route::get('/categories', [AdminProductCategoryController::class, 'index'])
        ->name('admin.categories.index');
    Route::post('/categories', [AdminProductCategoryController::class, 'store'])
        ->name('admin.categories.store');
    Route::put('/categories/{category}', [AdminProductCategoryController::class, 'update'])
        ->name('admin.categories.update');
    Route::delete('/categories/{category}', [AdminProductCategoryController::class, 'destroy'])
        ->name('admin.categories.destroy');

    Route::get('/industries', [AdminIndustryController::class, 'index'])
        ->name('admin.industries.index');
    Route::post('/industries', [AdminIndustryController::class, 'store'])
        ->name('admin.industries.store');
    Route::put('/industries/{industry}', [AdminIndustryController::class, 'update'])
        ->name('admin.industries.update');
    Route::delete('/industries/{industry}', [AdminIndustryController::class, 'destroy'])
        ->name('admin.industries.destroy');
});
