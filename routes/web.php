<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\QyasatController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\redirectAdmin;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;

// User Routes Start
Route::redirect('/', '/admin');

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]); 
// });








// Admin Routes Start

// Auth The Admin

Route::group(['prefix' => 'admin', 'middleware' => redirectAdmin::class], function () {

    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


Route::redirect('/', 'admin/dashboard');
Route::redirect('/dashboard', 'admin/dashboard');
Route::redirect('/admin', '/dashboard');

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {




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
    Route::put('/employees/permession/update/{id}', [EmployeeController::class, 'updatePermession'])->name('admin.employees.permession.update');
    Route::delete('/employees/destroy/{id}', [EmployeeController::class, 'destroy'])->name('admin.employees.destroy');
    Route::delete('/employees/image/{id}', [EmployeeController::class, 'deleteImage'])->name('admin.employees.image.delete');





    //Qyasat Route
    Route::get('/qyasat', [QyasatController::class, 'index'])->name('admin.qyasat.index');
    Route::post('/qyasat/store', [QyasatController::class, 'store'])->name('admin.qyasat.store');
    Route::post('/qyasat/store/order', [QyasatController::class, 'storeOrder'])->name('admin.qyasat.store.order');
    Route::put('/qyasat/update/{id}', [QyasatController::class, 'update'])->name('admin.qyasat.update');
    Route::delete('/qyasat/destroy/{id}', [QyasatController::class, 'destroy'])->name('admin.qyasat.destroy');
    Route::delete('/qyasat/image/{id}', [QyasatController::class, 'deleteImage'])->name('admin.qyasat.image.delete');


    //Orders Route
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/orders/store', [QyasatController::class, 'store'])->name('admin.orders.store');
    Route::put('/orders/update/{id}', [QyasatController::class, 'update'])->name('admin.orders.update');
    Route::delete('/orders/destroy/{id}', [QyasatController::class, 'destroy'])->name('admin.orders.destroy');
    Route::delete('/orders/image/{id}', [QyasatController::class, 'deleteImage'])->name('admin.orders.image.delete');
});
// Admin Routes End



// User Route Start

//Dashboard Route
Route::redirect('/', 'user/dashboard');
Route::redirect('/dashboard', 'user/dashboard');
Route::redirect('/user', 'dashboard');
Route::middleware(['auth', UserMiddleware::class])->prefix('user')->group(function () {

    Route::get('dashboard', [UserController::class, 'index'])->name('user.dashboard');

    Route::get('/permessions', [UserController::class, 'permessions'])->name('user.permessions');
    //Products Route
    Route::get('/products', [ProductController::class, 'index'])->name('user.products.index');
    Route::get('/products/supply', [ProductController::class, 'supply'])->name('user.products.supply');
    Route::post('/products/supply/{id}', [ProductController::class, 'refill'])->name('user.products.supply.add');
    Route::post('/products/store', [ProductController::class, 'store'])->name('user.products.store');
    Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('user.products.update');
    Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('user.products.destroy');



    //Companies Route
    Route::get('/companies', [CompanyController::class, 'index'])->name('user.companies.index');
    Route::post('/companies/store', [CompanyController::class, 'store'])->name('user.companies.store');
    Route::put('/companies/update/{id}', [CompanyController::class, 'update'])->name('user.companies.update');
    Route::delete('/companies/destroy/{id}', [CompanyController::class, 'destroy'])->name('user.companies.destroy');


    //Categores Route
    Route::get('/categories', [CategoryController::class, 'index'])->name('user.categories.index');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('user.categories.store');
    Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('user.categories.update');
    Route::delete('/categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('user.categories.destroy');

    //Employee Route
    Route::get('/employees', [EmployeeController::class, 'index'])->name('user.employees.index');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('user.employees.store');
    Route::put('/employees/update/{id}', [EmployeeController::class, 'update'])->name('user.employees.update');
    Route::put('/employees/permession/update/{id}', [EmployeeController::class, 'updatePermession'])->name('user.employees.permession.update');
    Route::delete('/employees/destroy/{id}', [EmployeeController::class, 'destroy'])->name('user.employees.destroy');
    Route::delete('/employees/image/{id}', [EmployeeController::class, 'deleteImage'])->name('user.employees.image.delete');

    //Qyasat Route
    Route::get('/qyasat', [QyasatController::class, 'index'])->name('user.qyasat.index');
    Route::post('/qyasat/store', [QyasatController::class, 'store'])->name('user.qyasat.store');
    Route::put('/qyasat/update/{id}', [QyasatController::class, 'update'])->name('user.qyasat.update');
    Route::delete('/qyasat/destroy/{id}', [QyasatController::class, 'destroy'])->name('user.qyasat.destroy');
    Route::delete('/qyasat/image/{id}', [QyasatController::class, 'deleteImage'])->name('user.qyasat.image.delete');


    //Orders Route
    Route::get('/orders', [OrderController::class, 'index'])->name('user.orders.index');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('user.orders.store');
    Route::put('/orders/update/{id}', [OrderController::class, 'update'])->name('user.orders.update');
    Route::delete('/orders/destroy/{id}', [OrderController::class, 'destroy'])->name('user.orders.destroy');
    Route::delete('/orders/image/{id}', [OrderController::class, 'deleteImage'])->name('user.orders.image.delete');
});

// User Route End



require __DIR__ . '/auth.php';
