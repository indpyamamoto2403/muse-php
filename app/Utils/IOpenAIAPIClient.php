<?php

namespace App\Utils;

interface IOpenAIAPIClient
{
    /**
     * Fetch an answer from the AI using only text.
     *
     * @param string $prompt The prompt text.
     * @return string|array The AI's response.
     */
    public function fetchAnswer(string $prompt): string|array;

    /**
     * Fetch an answer from the AI using text and an image.
     *
     * @param string $prompt The prompt text.
     * @param string $encodedImage The base64 encoded image.
     * @return string|array The AI's response.
     */
    public function fetchAnswerWithImage(string $prompt, string $encodedImage): string|array;
}
