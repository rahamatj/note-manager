<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SummarizeController extends Controller
{
    public function summarize(Request $request, $text)
    {
        $apiKey = env('OPEN_AI_API_KEY');
        $client = new Client();

        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4o', // Use 'gpt-4o' for Copilot-level access
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You summarize texts concisely.',
                    ],
                    [
                        'role' => 'user',
                        // 'content' => "Summarize this: {$text}",
                        'content'=> 'tell me a joke',
                    ],
                ],
                'max_tokens' => 200,
                'temperature' => 0.5,
            ],
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        $summary = $body['choices'][0]['message']['content'] ?? 'No summary generated.';

        return response()->json(['summary' => $summary]);
    }
}