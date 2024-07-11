<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\redirectAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// User Routes Start
Route::redirect('/', '/login');


// Route::get('/', function () {




//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]); 
// });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Routes End





// Admin Routes Start

// Auth The Admin

Route::group(['prefix' => 'admin', 'middleware' => redirectAdmin::class], function () {

    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {

    //Dashboard Route
    Route::redirect('/', 'admin/dashboard');
    Route::redirect('/admin', 'admin/dashboard');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    //Products Route
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/supply', [ProductController::class, 'supply'])->name('admin.products.supply');
    Route::post('/products/supply/{id}', [ProductController::class, 'refill'])->name('admin.products.supply.add');
    Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');



    //Companies Route
    Route::get('/companies', [CompanyController::class, 'index'])->name('admin.companies.index');
    Route::post('/companies/store', [CompanyController::class, 'store'])->name('admin.companies.store');
    Route::put('/companies/update/{id}', [CompanyController::class, 'update'])->name('admin.companies.update');
    Route::delete('/companies/destroy/{id}', [CompanyController::class, 'destroy'])->name('admin.companies.destroy');


    //Categores Route
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    //Employee Route
    Route::get('/employees', [EmployeeController::class, 'index'])->name('admin.employees.index');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('admin.employees.store');
    Route::put('/employees/update/{id}', [EmployeeController::class, 'update'])->name('admin.employees.update');
    Route::delete('/employees/destroy/{id}', [EmployeeController::class, 'destroy'])->name('admin.employees.destroy');
    Route::delete('/employees/image/{id}', [EmployeeController::class, 'deleteImage'])->name('admin.employees.image.delete');
});



// Admin Routes End

require __DIR__ . '/auth.php';
