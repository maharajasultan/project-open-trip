<?php
// routes/web.php — VERSI LENGKAP FINAL (termasuk User CRUD + Review + Penyelamat Report)

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MountainController    as AdminMountainController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\UserController        as AdminUserController;
use App\Http\Controllers\Admin\ReviewController      as AdminReviewController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\MountainController     as UserMountainController;
use App\Http\Controllers\User\TransactionController  as UserTransactionController;
use App\Http\Controllers\User\ReviewController       as UserReviewController;

// ══════════════════════════════════════════════════════════════
// GUEST ROUTES
// ══════════════════════════════════════════════════════════════
Route::middleware('guest')->group(function () {
    Route::get('/login',     [LoginController::class,    'showLogin'])->name('login');
    Route::post('/login',    [LoginController::class,    'login'])->name('login.post');
    Route::get('/register',  [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ══════════════════════════════════════════════════════════════
// PUBLIC FRONTEND ROUTES
// ══════════════════════════════════════════════════════════════
Route::get('/',                     [HomeController::class,         'index'])->name('home');
Route::get('/mountains/{mountain}', [UserMountainController::class, 'show'])->name('mountains.show');
Route::get('/private-trip',         [HomeController::class,         'privateTrip'])->name('private-trip');
Route::get('/about',                [HomeController::class,         'about'])->name('about');

// ══════════════════════════════════════════════════════════════
// USER AUTHENTICATED ROUTES
// ══════════════════════════════════════════════════════════════
Route::middleware(['auth', 'role.user'])->group(function () {

    // Checkout
    Route::get('/checkout/{mountain}',  [UserTransactionController::class, 'showCheckoutForm'])->name('checkout.form');
    Route::post('/checkout/{mountain}', [UserTransactionController::class, 'processCheckout'])->name('checkout.process');

    // Pembayaran
    Route::get('/payment/{transaction}', [UserTransactionController::class, 'payment'])->name('payment.show');

    // Riwayat
    Route::get('/history', [UserTransactionController::class, 'history'])->name('history');

    // ── REVIEW ROUTES ──────────────────────────────────────
    // Submit review (setelah pembayaran sukses)
    Route::post('/mountains/{mountain}/review',        [UserReviewController::class, 'store'])->name('reviews.store');
    // Update review sendiri
    Route::put('/reviews/{review}',                    [UserReviewController::class, 'update'])->name('reviews.update');
    // Hapus review sendiri
    Route::delete('/reviews/{review}',                 [UserReviewController::class, 'destroy'])->name('reviews.destroy');
});

// ══════════════════════════════════════════════════════════════
// MIDTRANS WEBHOOK (no auth — dipanggil server Midtrans)
// ══════════════════════════════════════════════════════════════
Route::post('/midtrans/notification',
    [UserTransactionController::class, 'handleNotification']
)->name('midtrans.notification');

// ══════════════════════════════════════════════════════════════
// ADMIN ROUTES
// ══════════════════════════════════════════════════════════════
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Gunung (CRUD lengkap)
    Route::resource('mountains', AdminMountainController::class);

    // Manajemen Transaksi
    Route::get('/transactions',                          [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}',            [AdminTransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{transaction}/status',   [AdminTransactionController::class, 'updateStatus'])->name('transactions.updateStatus');

    // ── MANAJEMEN USER (CRUD + Role) ───────────────────────
    Route::resource('users', AdminUserController::class);

    // ── MANAJEMEN REVIEW ───────────────────────────────────
    // Daftar semua review
    Route::get('/reviews',                               [AdminReviewController::class, 'index'])->name('reviews.index');
    // Admin balas komentar
    Route::post('/reviews/{review}/reply',               [AdminReviewController::class, 'reply'])->name('reviews.reply');
    // Hapus balasan admin
    Route::delete('/reviews/{review}/reply',             [AdminReviewController::class, 'deleteReply'])->name('reviews.deleteReply');
    // Toggle visibility review
    Route::patch('/reviews/{review}/toggle',             [AdminReviewController::class, 'toggleVisibility'])->name('reviews.toggle');
    // Hapus review
    Route::delete('/reviews/{review}',                   [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // ── MANAJEMEN LAPORAN BULANAN ──────────────────────────
    // Route penampung agar sidebar admin tidak error Route NotFound
    Route::get('/reports', function () {
        return 'Halaman Laporan Bulanan (Sedang Dalam Pengembangan / Fitur Selanjutnya).';
    })->name('reports.index');
});