<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AssignmentMonitoringController as AdminAssignmentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HomeContentController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\AnnouncementController as GuruAnnouncementController;
use App\Http\Controllers\Guru\AssignmentController as GuruAssignmentController;
use App\Http\Controllers\Guru\GuruController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\AssignmentController as UserAssignmentController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeController::class)->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User Routes
Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/attendance', [UserController::class, 'attendanceForm']);
    Route::post('/attendance', [UserController::class, 'submitAttendance']);
    Route::get('/history', [UserController::class, 'history']);
    Route::get('/permission', [UserController::class, 'permissionForm'])->name('user.permission');
    Route::post('/permission', [UserController::class, 'submitPermission'])->name('user.submit.permission');

    // Assignment Routes for User
    Route::get('/assignments', [UserAssignmentController::class, 'index'])->name('user.assignments.index');
    Route::get('/assignments/{assignment}', [UserAssignmentController::class, 'show'])->name('user.assignments.show');
    Route::post('/assignments/{assignment}/submit', [UserAssignmentController::class, 'submit'])->name('user.assignments.submit');
});

// Guru Routes
Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/report', [GuruController::class, 'report'])->name('guru.report');
    Route::get('/report/export', [GuruController::class, 'export'])->name('guru.report.export');
    Route::get('/permissions', [GuruController::class, 'permissions'])->name('guru.permissions');
    Route::post('/validate-permission/{id}', [GuruController::class, 'validatePermission'])->name('guru.validate.permission');
    Route::get('/permission/{id}', [GuruController::class, 'show'])->name('guru.permission.show');
    Route::get('/manual-attendance', [GuruController::class, 'manualAttendance'])->name('guru.manual_attendance');
    Route::post('/manual-attendance', [GuruController::class, 'submitManualAttendance']);
    Route::get('/students/{room_id}', [GuruController::class, 'getStudentsByRoom'])->name('get.students');

    // Announcement Routes
    Route::resource('announcements', GuruAnnouncementController::class)->except(['show'])->names('guru.announcements');

    // Assignment Routes for Guru
    Route::resource('assignments', GuruAssignmentController::class)->except(['edit', 'update'])->names('guru.assignments');
    Route::post('/submissions/{submission}/grade', [GuruAssignmentController::class, 'grade'])->name('guru.submissions.grade');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('admin.dashboard');

    Route::resource('home', HomeContentController::class)->except(['show'])->names('admin.home');
    Route::resource('about', AboutController::class)->except(['show'])->names('admin.about');
    Route::resource('gallery', GalleryController::class)->except(['show'])->names('admin.gallery');
    Route::resource('projects', ProjectController::class)->except(['show'])->names('admin.projects');
    Route::resource('students', StudentController::class)->except(['show'])->names('admin.students');
    Route::resource('users', AdminUserController::class)->names([
        'index'   => 'admin.users.index',
        'create'  => 'admin.users.create',
        'store'   => 'admin.users.store',
        'edit'    => 'admin.users.edit',
        'update'  => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    Route::resource('locations', LocationController::class)->except(['show'])->names('admin.locations');
    Route::resource('rooms', RoomController::class)->except(['show'])->names('admin.rooms');
    Route::get('/assignments', [AdminAssignmentController::class, 'index'])->name('admin.assignments.index');
});

// Profile Routes (Authenticated Users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
