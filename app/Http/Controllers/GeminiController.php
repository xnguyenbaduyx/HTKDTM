<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GeminiAPI\Client as GeminiClient; 
use Illuminate\Support\Facades\Log;

class GeminiController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $question = $request->input('question');

        try {
            $httpClient = new Client([
                'verify' => 'C:\Users\dacso\OneDrive\Máy tính\cacert.pem' 
            ]);
            $client = new GeminiClient(env('GEMINI_API_KEY'), $httpClient);

            $response = $client->geminiPro()->generateContent(
                new \GeminiAPI\Resources\Parts\TextPart($question) 
            );

            $answer = $response->text();

            return response()->json([
                'question' => $question,
                'answer' => $answer
            ]);
        } catch (\Exception $e) {
            Log::error('Gemini API error: ' . $e->getMessage());
            return response()->json(['error' => 'There was an error processing your request.'], 500);
        }
    }
    
}