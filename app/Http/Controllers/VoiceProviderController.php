<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\VoiceProvider;

class VoiceProviderController extends Controller
{
    protected $voiceProvider;
    public function __construct()
    {
        $this->voiceProvider = new VoiceProvider(
            env('SPEECH_REGION'),
            env('SPEECH_KEY')
        );
    }

    public function create(Request $request)
    {
        // リクエストにテキストが無い場合、モックテキストを使用
        $mockText = 'Hello, this is a test.';
        $textToSynthesize = $mockText; // 必要に応じてリクエストパラメータを優先するなどの実装も可能

        $audioData = $this->voiceProvider->synthesize(
            $textToSynthesize,
            'en-US-AriaNeural',
            'en-US'
        );
        return response($audioData)
            ->header('Content-Type', 'audio/mpeg')
            ->header('Content-Disposition', 'inline; filename="output.mp3"');
    }
}
