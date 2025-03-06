<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatService;
use Inertia\Inertia;
class DashboardController extends Controller
{
    private $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index()
    {
        $score = $this->chatService->getLatestScore();
        return Inertia::render("Dashboard", [
            'score' => $score,
        ]);
    }

    public function print()
    {
        $score = $this->chatService->getLatestScore();
        return Inertia::render('DashboardPrint', [
            'score' => $score,
        ]);
    }
}
