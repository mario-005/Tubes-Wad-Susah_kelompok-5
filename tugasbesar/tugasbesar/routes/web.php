<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OperationalStatusController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\RumahMakanController;

// Home route
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rumah Makan routes
    Route::resource('rumah-makan', RumahMakanController::class);

    // Menu routes
    Route::resource('menus', MenuController::class);

    // Room routes
    Route::resource('rooms', RoomController::class);

    // Reservation routes
    Route::resource('reservations', ReservationController::class);
    Route::get('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

    // Operational Status routes
    Route::resource('operational-statuses', OperationalStatusController::class);
    Route::get('/status-realtime', [OperationalStatusController::class, 'realTimeStatus'])->name('status.realtime');

    // User routes - can add reviews
    Route::middleware('user')->group(function () {
        Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
        Route::get('/ulasan/create', [UlasanController::class, 'create'])->name('ulasan.create');
        Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
        Route::get('/ulasan/{ulasan}', [UlasanController::class, 'show'])->name('ulasan.show');
    });

    // Admin routes - can edit and delete reviews
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
        Route::get('/ulasan/{ulasan}', [UlasanController::class, 'show'])->name('ulasan.show');
        Route::get('/ulasan/{ulasan}/edit', [UlasanController::class, 'edit'])->name('ulasan.edit');
        Route::put('/ulasan/{ulasan}', [UlasanController::class, 'update'])->name('ulasan.update');
        Route::delete('/ulasan/{ulasan}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
    });
});