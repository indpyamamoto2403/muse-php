<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
class QuestionController extends Controller
{
    public function index()
    {
        return Inertia::render('Questions/Index', [
            'questions' => Question::all(),
        ]);
    }

    public function register()
    {
        return Inertia::render('Questions/Register');
    }

    public function store(Request $request)
    {

        Question::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('questions.index')->with('success', 'Question created successfully.');
    }
}
