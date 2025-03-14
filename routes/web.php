<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtController;
use App\Http\Controllers\ArtApiController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatAPIController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConversationChatController;
use App\Http\Controllers\VoiceProviderController;
use App\Http\Controllers\AudioTestController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ImageQuestionController;
use App\Http\Controllers\EmailSentController;
use App\Http\Controllers\EmailController;
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

Route::middleware('auth')->group(function () {

    //共通属性
    # ダッシュボードのコントローラーを呼び出す
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/dashboard/print', [DashboardController::class, 'print'])->name('dashboard.print');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/user-icon.set', [ProfileController::class, 'setUserIcon'])->name('user-icon.set');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    //会話チャット機能
    Route::get('/conversations', [ConversationChatController::class, 'index'])->name('conversations.index');
    
    // 受信者IDをパラメータとして受け取るルートに変更
    Route::get('/conversations/{recepterId}', [ConversationChatController::class, 'show'])->name('conversations.show');
    Route::post('/conversations/send', [ConversationChatController::class, 'sendMessage'])->name('conversations.send');

    // いいね機能・保存機能のルート
    Route::post('api/like', [ArtApiController::class, 'like'])->name('like');
    Route::post('api/save', [ArtApiController::class, 'save'])->name('save');
    
    // コメント機能のルート
    Route::post('api/comment', [ArtApiController::class, 'comment'])->name('comment');

    // お気に入り作品一覧表示
    Route::get('/art/favorite', [ArtController::class, 'favorite'])->name('art.favorite');

    // メール送信機能
    Route::post('/send-email', [EmailController::class, 'sendEmail'])->name('send.email');

    //ロールが企業の場合
    Route::middleware('company')->group(function () {

        Route::get('/art',[ArtController::class,'index'])->name('art.index');
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index')->middleware('evaluation.exists');

        // チャット機能・
        Route::get('/chat/questions', [ChatController::class, 'questions'])->name('chat.questions');
        Route::get('/chat/complete', [ChatController::class, 'complete'])->name('chat.complete');
        Route::get('/chat/history', [ChatController::class, 'history'])->name('chat.history');

        //画像を選ばせる機能
        Route::get('question/image/answer', [ImageQuestionController::class, 'answer'])->name('questions.image.answer');
        Route::post('question/image/answer', [ImageQuestionController::class, 'answerStore'])->name('questions.image.answerStore');

        // チャットAPI実装機能
        Route::post('/api/chat', [ChatAPIController::class, 'send'])->name('chat.send');//->middleware('evaluation.exists');
        Route::post('api/chat/answer', [ChatAPIController::class, 'answer'])->name('chat.answer');
        Route::post('/api/chat/all', [ChatAPIController::class, 'sendAll'])->name('chat.sendAll');//->middleware('evaluation.exists');

        // 音声ファイル生成機能
        Route::get('/api/voice', [VoiceProviderController::class, 'createVoice'])->name('voice.createVoice');
    });

    //ロールが芸術家の場合
    Route::middleware('artist')->group(function () {
        Route::get('/art/register',[ArtController::class,'register'])->name('art.register');
        Route::post('/art/register',[ArtController::class,'create'])->name('art.create');
    });

    //ロールが管理者の場合（Adminのみアクセス可能）
    Route::middleware('admin')->group(function () {
        Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
        Route::get('/questions/register', [QuestionController::class, 'register'])->name('question.register');
        Route::post('/questions/store', [QuestionController::class, 'store'])->name('question.store');
        
        Route::get('/questions/image/register', [ImageQuestionController::class, 'register'])->name('questions.image.register');
        Route::post('/questions/image/upload', [ImageQuestionController::class, 'upload'])->name('questions.image.upload');
        Route::delete('/questions/image/destroy/{id}', [ImageQuestionController::class, 'destroy'])->name('questions.image.destroy');
    });
});



require __DIR__.'/auth.php';
