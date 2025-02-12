<?php

namespace App\Http\Controllers;

use App\Services\ArtService;
use App\Services\EvaluationService;
use Inertia\Inertia;
use App\Models\Art;
use Illuminate\Http\Request;
class ArtController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $arts = Art::all();
        return Inertia::render('Art/Index', [
            'arts' => $arts
        ]);
    }

    /**
     * @return void
     */
    public function register()
    {
        return Inertia::render('Art/Register');
    }

    /**
     * @return void
     */
    public function create(Request $request)
    {
        $path = $request->file('image')->store('public/images');
        return response()->json(Art::All());
    }

    /**
     * @param  \App\Models\Art  $art
     * @return \Illuminate\Http\Response
     */
    public function destroy(Art $art)
    {
        $art->delete();
        return response()->json([
            'message' => 'Art deleted successfully'
        ]);
    }
}
