<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\FeedbackController;
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
})->middleware(['auth', 'verified', 'user'])->name('dashboard');

// Public Map Route
Route::get('/map', [MapController::class, 'index'])->name('map.index');
Route::get('/api/reports/map', [MapController::class, 'getReports'])->name('api.reports.map');

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Reports Routes
    Route::resource('reports', \App\Http\Controllers\ReportController::class);
    
    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get('/notifications/count', [NotificationController::class, 'unreadCount'])->name('notifications.count');
    
    // Feedback Routes
    Route::post('/reports/{report}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
});

// Admin Routes - Protected by admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/user', [\App\Http\Controllers\AdminController::class, 'userDashboard'])->name('dashboard.user');
    
    // Admin Profile Routes
    Route::get('/profile', [\App\Http\Controllers\AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\AdminProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Report Management Routes
    Route::patch('/reports/{report}/approve', [\App\Http\Controllers\AdminController::class, 'approve'])->name('approve');
    Route::patch('/reports/{report}/reject', [\App\Http\Controllers\AdminController::class, 'reject'])->name('reject');
    Route::get('/reports/{report}/detail', [\App\Http\Controllers\AdminController::class, 'reportDetail'])->name('report.detail');
    
    // User Management Routes
    Route::resource('users', \App\Http\Controllers\UserManagementController::class);
    
    // Feedback Routes
    Route::get('/feedbacks', [\App\Http\Controllers\AdminController::class, 'feedbacks'])->name('feedbacks.index');
    
    // Map Routes
    Route::get('/map', [\App\Http\Controllers\AdminController::class, 'map'])->name('map');
});

require __DIR__.'/auth.php';
