<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $message = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $response = Http::post($url, [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $message]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $answer = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Sin respuesta';
            return response()->json(['answer' => $answer]);
        } else {
            return response()->json(['answer' => 'Error al conectar con Gemini'], 500);
        }
    }
}
