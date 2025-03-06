<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class ChatRepository
{
    /**
     * チャットの返答を返す
     * @param string $message
     * @return string $answer
     */
    public function save(array $score)
    {
        $evaluation = new Evaluation();
        $evaluation->user_id = Auth::user()->id;
        $evaluation->style = $score['style'];
        $evaluation->tradition_innovation = $score['tradition_innovation'];
        $evaluation->introspective_emotional = $score['introspective_emotional'];
        $evaluation->color_sense = $score['color_sense'];
        $evaluation->composition = $score['composition'];
        $evaluation->technique = $score['technique'];
        $evaluation->theme = $score['theme'];
        $evaluation->energy = $score['energy'];
        $evaluation->uniqueness = $score['uniqueness'];
        $evaluation->save();
    }

    /**
     * @return Evaluation
     */
    public function getLatest() : ?Evaluation
    {
        $evaluation = Evaluation::where('user_id', Auth::user()->id)->latest()->first() ?? null;
        return $evaluation;
    }
}