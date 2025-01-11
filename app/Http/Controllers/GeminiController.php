<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GeminiAPI\Client as GeminiClient; // Giả sử bạn dùng thư viện này
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
            // **Cách 1: Tắt kiểm tra chứng chỉ (CHỈ DÙNG CHO DEBUG)**
            // $httpClient = new Client([
            //     'verify' => false
            // ]);
            // $client = new GeminiClient(env('GEMINI_API_KEY'), $httpClient);

            // **Cách 2: Sử dụng đường dẫn đến cacert.pem (KHUYẾN NGHỊ HƠN)**
            $httpClient = new Client([
                'verify' => 'D:\cnw\cacert.pem' // **Đảm bảo đường dẫn này chính xác**
            ]);
            $client = new GeminiClient(env('GEMINI_API_KEY'), $httpClient);

            // Hoặc nếu thư viện GeminiAPI tự xử lý Guzzle client:
             //$client = new GeminiClient(env('GEMINI_API_KEY'),['verify' => 'C:\xampp\php\extras\ssl\cacert.pem']);

            $response = $client->geminiPro()->generateContent(
                new \GeminiAPI\Resources\Parts\TextPart($question) // Đảm bảo namespace chính xác
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