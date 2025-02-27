<?php

namespace App\Http\Controllers;

use App\Services\ArtService;
use App\Services\EvaluationService;
use App\Services\ArtSimilarityService;
use Inertia\Inertia;
use App\Models\Art;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ArtController extends Controller
{
    protected $artService;
    protected $evaluationService;
    protected $artSimilarityService;

    //コンストラクタ
    public function __construct(ArtSimilarityService $artSimilarityService, 
                                ArtService $artService, 
                                EvaluationService $evaluationService)
    {
        $this->artService = $artService;
        $this->evaluationService = $evaluationService;
        $this->artSimilarityService = $artSimilarityService;
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $arts = $this->artService->getAllArts();
        
        $rank = $this->artSimilarityService->getRank(Auth::id()); 
        //Rankの対応表みたいなもの。　id,3 ; similarity:0.223 ; id,4 ; similarity:0.123; id,5 ; similarity:0.023;

        $rankedArt = $this->artSimilarityService->getRankedArts($arts, $rank); //similarityを付与したArtのリスト

        return Inertia::render('Art/Index', [

            'arts' => $rankedArt
            
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
        $path = $request->file('image')->store('images', 'public');

        Art::Create([
            'title' => $request->title,
            'image' => $path,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);
        
        return Inertia::render('Art/Index', [
            'arts' => Art::all()
        ]);
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
