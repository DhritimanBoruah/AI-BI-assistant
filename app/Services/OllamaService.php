<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OllamaService
{
    protected $baseUrl = 'http://127.0.0.1:11434/api/generate';

    public function ask($prompt)
    {
        $response = Http::timeout(120)->post($this->baseUrl, [
            'model' => 'llama3:latest',
            'prompt' => $prompt,
            'stream' => false,
        ]);

        if ($response->successful()) {
            return $response->json()['response'];
        }

        return null;
    }
}