<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Import crucial pour l'API
use App\Models\Message;

class ChatController extends Controller
{
    public function ask(Request $request)
    {
        $userMessage = $request->input('message');
        
        // 1. Vérification de la clé API
        $apiKey = env('GROQ_API_KEY');
        if (!$apiKey) {
            return response()->json(['reply' => 'Erreur : La clé GROQ_API_KEY est manquante dans le fichier .env'], 500);
        }

        try {
            // 2. Appel à l'IA Groq
            // On ajoute ->withoutVerifying() pour ignorer le problème de certificat en local
$response = Http::withoutVerifying()->withHeaders([
    'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
    'Content-Type' => 'application/json',
])->post('https://api.groq.com/openai/v1/chat/completions', [
    'model' => 'llama-3.3-70b-versatile',
    'messages' => [
        ['role' => 'user', 'content' => $userMessage],
    ],
]);

            if ($response->failed()) {
                return response()->json(['reply' => 'Erreur Groq : ' . $response->body()], 500);
            }

            $botResponse = $response->json()['choices'][0]['message']['content'];

            // 3. Sauvegarde dans MySQL
            // Assure-toi que ton modèle Message a bien le protected $fillable
            Message::create(['role' => 'user', 'content' => $userMessage]);
            Message::create(['role' => 'assistant', 'content' => $botResponse]);

            return response()->json(['reply' => $botResponse]);

        } catch (\Exception $e) {
            return response()->json(['reply' => 'Erreur système : ' . $e->getMessage()], 500);
        }
    }
}
