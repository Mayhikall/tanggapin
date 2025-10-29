<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect('/admin/dashboard');
        }
        
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Reports Routes
    Route::resource('reports', \App\Http\Controllers\ReportController::class);
});

// Admin Routes - Protected by admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Report Management Routes
    Route::patch('/reports/{report}/approve', [\App\Http\Controllers\AdminController::class, 'approve'])->name('approve');
    Route::patch('/reports/{report}/reject', [\App\Http\Controllers\AdminController::class, 'reject'])->name('reject');
    Route::get('/reports/{report}/detail', [\App\Http\Controllers\AdminController::class, 'reportDetail'])->name('report.detail');
});

require __DIR__.'/auth.php';
