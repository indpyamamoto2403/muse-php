<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatAPIController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    //共通属性
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //ロールが企業の場合
    Route::middleware('company')->group(function () {

        Route::get('/art',[ArtController::class,'index'])->name('art.index');
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
        

        // チャットAPI実装機能
        Route::post('/api/chat', [ChatAPIController::class, 'send'])->name('chat.send');
        Route::post('/api/chat/all', [ChatAPIController::class, 'sendAll'])->name('chat.sendAll');

    });

    //ロールが芸術家の場合
    Route::middleware('artist')->group(function () {
        Route::get('/art/register',[ArtController::class,'register'])->name('art.register');
        Route::post('/art/register',[ArtController::class,'create'])->name('art.create');
    });
});


require __DIR__.'/auth.php';
