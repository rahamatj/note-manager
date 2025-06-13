<?php
use GuzzleHttp\Client;

function summarize(Request $request)
{
    $openaiApiKey = env('OPENAI_API_KEY');
    $textToSummarize = $request->input('text');

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $openaiApiKey,
        'Content-Type' => 'application/json',
    ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo', // or 'gpt-4'
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant that summarizes text.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Summarize the following text:\n" . $textToSummarize,
                    ],
                ],
                'max_tokens' => 200,
                'temperature' => 0.7,
            ]);

    $summary = $response->json('choices.0.message.content');

    return response()->json(['summary' => $summary]);
}