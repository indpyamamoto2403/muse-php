<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\VoiceProvider;
use Illuminate\Support\Facades\Log;
class VoiceProviderController extends Controller
{
    private $voiceProvider;
    public function __construct()
    {
        $this->voiceProvider = new VoiceProvider(env('SPEECH_REGION'), env('SPEECH_KEY'));
    }

    public function createVoice(Request $request)
    {
        $text = $request->text;
        $audioURL = $this->voiceProvider->createAndGetAudioURL($text);
        Log::debug("音声ファイルのURL: " . $audioURL);
        return response()->json([
            'audioURL' => $audioURL
        ]);
    }
}
