<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OperationalStatusController;
use App\Http\Controllers\UlasanController;


// mario

Route::get('/', function () {
    return redirect()->route('login'); 
});

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
 
// Route::get('/dashboard', [DashboardController::class])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('menus', MenuController::class);

// raka

Route::get('/', [RoomController::class, 'index']);

Route::resource('rooms', RoomController::class);
Route::resource('reservations', ReservationController::class);
Route::get('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');


// novi

Route::get('/', fn () => redirect('/operational-statuses'));
Route::resource('operational-statuses', OperationalStatusController::class);
Route::get('/status-realtime', [OperationalStatusController::class, 'realTimeStatus'])->name('status.realtime');
Route::get('/dashboard', [OperationalStatusController::class, 'index'])->name('dashboard');

// sasi

Route::get('/', function () {
    return redirect()->route('login'); 
});

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('/dashboard', [DashboardController::class])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('menus', MenuController::class);


// Bili


// Home route
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User routes - hanya bisa menambah ulasan
    Route::middleware('user')->group(function () {
        Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
        Route::get('/ulasan/create', [UlasanController::class, 'create'])->name('ulasan.create');
        Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
        Route::get('/ulasan/{ulasan}', [UlasanController::class, 'show'])->name('ulasan.show');
    });

    // Admin routes - hanya bisa edit dan hapus ulasan
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
        Route::get('/ulasan/{ulasan}', [UlasanController::class, 'show'])->name('ulasan.show');
        Route::get('/ulasan/{ulasan}/edit', [UlasanController::class, 'edit'])->name('ulasan.edit');
        Route::put('/ulasan/{ulasan}', [UlasanController::class, 'update'])->name('ulasan.update');
        Route::delete('/ulasan/{ulasan}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
    });
});