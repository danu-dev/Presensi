<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeContentController;

Route::get('/', function () {
    $homeContents = \App\Models\HomeContent::all();
    $abouts = \App\Models\About::all();
    $galleries = \App\Models\Gallery::all();
    $projects = \App\Models\Project::all();
    $students = \App\Models\Student::all();
    return view('welcome', compact('homeContents', 'abouts', 'galleries', 'projects', 'students'));
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
//  Route::get('/register', [AuthController::class, 'showRegister']);
// Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Routes
Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/attendance', [UserController::class, 'attendanceForm']);
    Route::post('/attendance', [UserController::class, 'submitAttendance']);
    Route::get('/history', [UserController::class, 'history']);
    Route::get('/permission', [UserController::class, 'permissionForm'])->name('user.permission');
    Route::post('/permission', [UserController::class, 'submitPermission'])->name('user.submit.permission');
});

// Guru Routes
Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/report', [GuruController::class, 'report'])->name('guru.report');
    Route::get('/report/export', [GuruController::class, 'export'])->name('guru.report.export');
    Route::get('/permissions', [GuruController::class, 'permissions'])->name('guru.permissions');
    Route::post('/validate-permission/{id}', [GuruController::class, 'validatePermission'])->name('guru.validate.permission');
    Route::get('/permission/{id}', [GuruController::class, 'show'])->name('guru.permission.show');
    Route::get('/manual-attendance', [App\Http\Controllers\GuruController::class, 'manualAttendance'])->name('guru.manual_attendance');
Route::post('/manual-attendance', [App\Http\Controllers\GuruController::class, 'manualAttendance']);
Route::get('/students/{room_id}', [App\Http\Controllers\GuruController::class, 'getStudentsByRoom'])->name('get.students');
Route::get('/manual-attendance', [GuruController::class, 'manualAttendance'])->name('guru.manual_attendance');
Route::post('/manual-attendance', [GuruController::class, 'submitManualAttendance']);
Route::get('/students/{room_id}', [GuruController::class, 'getStudentsByRoom'])->name('get.students');

});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Home Routes
    Route::get('/home', [HomeContentController::class, 'index'])->name('admin.home.index');
    Route::get('/home/create', [HomeContentController::class, 'create'])->name('admin.home.create');
    Route::post('/home', [HomeContentController::class, 'store'])->name('admin.home.store');
    Route::get('/home/{homeContent}/edit', [HomeContentController::class, 'edit'])->name('admin.home.edit');
    Route::put('/home/{homeContent}', [HomeContentController::class, 'update'])->name('admin.home.update');
    Route::delete('/home/{homeContent}', [HomeContentController::class, 'destroy'])->name('admin.home.destroy');

    // About Routes
    Route::get('/about', [AboutController::class, 'index'])->name('admin.about.index');
    Route::get('/about/create', [AboutController::class, 'create'])->name('admin.about.create');
    Route::post('/about', [AboutController::class, 'store'])->name('admin.about.store');
    Route::get('/about/{about}/edit', [AboutController::class, 'edit'])->name('admin.about.edit');
    Route::put('/about/{about}', [AboutController::class, 'update'])->name('admin.about.update');
    Route::delete('/about/{about}', [AboutController::class, 'destroy'])->name('admin.about.destroy');

    // Gallery Routes
    Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
    Route::get('/gallery/create', [GalleryController::class, 'create'])->name('admin.gallery.create');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
    Route::get('/gallery/{gallery}/edit', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
    Route::put('/gallery/{gallery}', [GalleryController::class, 'update'])->name('admin.gallery.update');
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');

    // Projects Routes
    Route::get('/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('admin.projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('admin.projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('admin.projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('admin.projects.destroy');

    // Students Routes
    Route::get('/students', [StudentController::class, 'index'])->name('admin.students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('admin.students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('admin.students.store');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('admin.students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('admin.students.destroy');

    // Users Resource
    Route::resource('users', AdminController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    // Locations Manual Routes
    Route::get('/locations', [AdminController::class, 'indexLocations'])->name('admin.locations.index');
    Route::get('/locations/create', [AdminController::class, 'createLocations'])->name('admin.locations.create');
    Route::post('/locations', [AdminController::class, 'storeLocations'])->name('admin.locations.store');
    Route::get('/locations/{id}/edit', [AdminController::class, 'editLocations'])->name('admin.locations.edit');
    Route::put('/locations/{id}', [AdminController::class, 'updateLocations'])->name('admin.locations.update');
    Route::delete('/locations/{id}', [AdminController::class, 'destroyLocations'])->name('admin.locations.destroy');

    // Rooms Manual Routes
    Route::get('/rooms', [AdminController::class, 'indexRooms'])->name('admin.rooms.index');
    Route::get('/rooms/create', [AdminController::class, 'createRooms'])->name('admin.rooms.create');
    Route::post('/rooms', [AdminController::class, 'storeRooms'])->name('admin.rooms.store');
    Route::get('/rooms/{id}/edit', [AdminController::class, 'editRooms'])->name('admin.rooms.edit');
    Route::put('/rooms/{id}', [AdminController::class, 'updateRooms'])->name('admin.rooms.update');
    Route::delete('/rooms/{id}', [AdminController::class, 'destroyRooms'])->name('admin.rooms.destroy');
});

// Profile Routes (Authenticated Users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});