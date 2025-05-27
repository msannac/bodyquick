<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $message = $request->input('message');
        $faqs = config('faq');

        // Buscar la pregunta más similar en las preguntas frecuentes
        $maxSimilarity = 0;
        $bestAnswer = null;
        foreach ($faqs as $faq) {
            similar_text(mb_strtolower($faq['question']), mb_strtolower($message), $percent);
            if ($percent > $maxSimilarity) {
                $maxSimilarity = $percent;
                $bestAnswer = $faq['answer'];
            }
        }
        // Si la similitud es mayor al 60%, se responde con el FAQ
        if ($maxSimilarity > 60) {
            return response()->json(['answer' => $bestAnswer]);
        }

        // Si no hay coincidencia suficiente, usar Gemini
        $apiKey = env('GEMINI_API_KEY');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $response = \Illuminate\Support\Facades\Http::post($url, [
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
