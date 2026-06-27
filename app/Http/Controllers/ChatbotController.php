<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    /**
     * Recherche conversationnelle de produits/services.
     * Proxy vers l'IA FastAPI (api_ai) qui interroge directement la base.
     *
     * Reponse JSON attendue par le front (chat_bot.blade.php) :
     *   { "reply": "...", "results": [ { name, category, product, ville,
     *     price, rating, image, url } ] }
     */
    public function search(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $message = trim((string) $request->input('message'));
        $hasImage = $request->hasFile('image');

        if ($message === '' && !$hasImage) {
            return response()->json([
                'reply'   => "Dites-moi quel produit ou service vous recherchez.",
                'results' => [],
            ]);
        }

        $baseUrl = config('services.chatbot_ai.url');
        $apiKey  = config('services.chatbot_ai.key');

        if (!$baseUrl) {
            return response()->json([
                'reply'   => "Le service de recherche intelligent n'est pas configuré pour le moment.",
                'results' => [],
            ], 503);
        }

        try {
            $http = Http::timeout(30);
            if ($apiKey) {
                $http = $http->withToken($apiKey);
            }

            if ($hasImage) {
                // Recherche par image -> endpoint /chatbot/upload
                $uploadUrl = rtrim($baseUrl, '/') . '/upload';
                $file = $request->file('image');
                $resp = $http->attach(
                    'image',
                    file_get_contents($file->getRealPath()),
                    $file->getClientOriginalName()
                )->post($uploadUrl, ['message' => $message]);
            } else {
                // Recherche texte -> endpoint /chatbot
                $resp = $http->acceptJson()->post($baseUrl, ['message' => $message]);
            }

            if ($resp->successful()) {
                $data = $resp->json();
                $results = collect($data['results'] ?? [])
                    ->map(fn (array $item) => $this->normalizeResult($item))
                    ->values()
                    ->all();

                return response()->json([
                    'reply'   => $data['reply'] ?? '',
                    'results' => $results,
                ]);
            }
        } catch (\Throwable $e) {
            // On renvoie un message clair sans exposer l'erreur technique.
        }

        return response()->json([
            'reply'   => "Désolé, le service de recherche est momentanément indisponible. Réessayez dans un instant.",
            'results' => [],
        ], 502);
    }

    /**
     * Corrige l'URL du commerce via les routes Laravel (évite les liens
     * cassés type http://localhost/commerces/1 quand l'app est dans un sous-dossier).
     */
    private function normalizeResult(array $item): array
    {
        $commerceId = $item['commerce_id'] ?? null;

        if (!$commerceId && !empty($item['url']) && preg_match('#/commerces/(\d+)#', $item['url'], $m)) {
            $commerceId = (int) $m[1];
        }

        if ($commerceId) {
            $item['url'] = route('commerces.show', ['commerce' => $commerceId]);
        }

        return $item;
    }
}
