<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatAPIController;
use App\Http\Controllers\VoiceProviderController;
use App\Http\Controllers\AudioTestController;
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
    Route::post('/profile/user-icon.set', [ProfileController::class, 'setUserIcon'])->name('user-icon.set');

    //ロールが企業の場合
    Route::middleware('company')->group(function () {

        Route::get('/art',[ArtController::class,'index'])->name('art.index');
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index')->middleware('evaluation.exists');
        Route::get('/chat/complete', [ChatController::class, 'complete'])->name('chat.complete');

        // チャットAPI実装機能
        Route::post('/api/chat', [ChatAPIController::class, 'send'])->name('chat.send');//->middleware('evaluation.exists');
        Route::post('/api/chat/all', [ChatAPIController::class, 'sendAll'])->name('chat.sendAll');//->middleware('evaluation.exists');

        // 音声ファイル生成機能
        Route::get('/api/voice', [VoiceProviderController::class, 'createVoice'])->name('voice.createVoice');
    });

    //ロールが芸術家の場合
    Route::middleware('artist')->group(function () {
        Route::get('/art/register',[ArtController::class,'register'])->name('art.register');
        Route::post('/art/register',[ArtController::class,'create'])->name('art.create');
    });
});


require __DIR__.'/auth.php';
