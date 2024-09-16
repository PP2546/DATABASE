<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryEntryController;
use App\Http\Controllers\GetConflictController;

// เส้นทางสาธารณะ
Route::get('/', function () {
    return view('welcome');
});

// เส้นทางแดชบอร์ด - ต้องการการพิสูจน์ตัวตนและการยืนยันอีเมล
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// เส้นทางที่ต้องการการพิสูจน์ตัวตน
Route::middleware('auth')->group(function () {
    // เส้นทางการจัดการบันทึกไดอารี่ (CRUD)
    Route::resource('diary', DiaryEntryController::class);
    Route::get('/conflict_emotion', [DiaryEntryController::class, 'conflict_diary'])->name('getconflict.conflicting_emotion');

    // การจัดการโปรไฟล์
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // การจัดการข้อมูลชีวประวัติ
    Route::get('/profile/bio', [UserController::class, 'showBio'])->name('profile.show-bio');
    Route::patch('/profile/bio', [UserController::class, 'updateBio'])->name('profile.update-bio');
});

// เส้นทางอัปเดตภาพโปรไฟล์
Route::post('/profile/photo/update', [UserController::class, 'updateProfilePhoto'])->name('profile.photo.update');

// เส้นทางการพิสูจน์ตัวตน
require __DIR__.'/auth.php';