<?php

namespace App\Utils;

class MockOpenAIAPIClient implements IOpenAIAPIClient
{
    /**
     * Mock implementation of fetchAnswer.
     * @param string $prompt The prompt text.
     * @return string|array The mock response.
     */
    public function fetchAnswer(string $prompt): string|array
    {
        return "これは、プロンプトのトークン料金を節約するために使用される応答のモックです。";
    }

    /**
     * Mock implementation of fetchAnswerWithImage.
     * @param string $prompt The prompt text.
     * @param string $encodedImage The base64 encoded image.
     * @return string|array The mock response.
     */
    public function fetchAnswerWithImage(string $prompt, string $encodedImage): string|array
    {
        return "This is a mock response for the prompt: " . $prompt . " with an image.";
    }
}
