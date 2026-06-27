<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Declenche le scoring IA (1 a 5 etoiles) via l'API FastAPI (api_ai).
 *
 * L'IA lit les commentaires en base, calcule les notes et met a jour
 * scoringCommerce / scoringService / scoringArtisant directement.
 */
class ScoringService
{
    private function baseUrl(): ?string
    {
        return config('services.scoring_ai.url');
    }

    private function client()
    {
        $http = Http::timeout((int) config('services.scoring_ai.timeout', 60));
        if ($key = config('services.scoring_ai.key')) {
            $http = $http->withToken($key);
        }
        return $http->acceptJson();
    }

    /**
     * Recalcule le score d'un commerce (+ ses services + l'artisan).
     * Ne leve jamais d'exception : un echec de scoring ne doit pas casser
     * l'action utilisateur (ex: poster un commentaire).
     */
    public function rescoreCommerce(int $commerceId): ?array
    {
        $base = $this->baseUrl();
        if (!$base) {
            return null;
        }

        try {
            $resp = $this->client()->post(rtrim($base, '/') . "/commerce/{$commerceId}");
            if ($resp->successful()) {
                return $resp->json();
            }
            Log::warning('Scoring commerce echoue', ['id' => $commerceId, 'status' => $resp->status()]);
        } catch (\Throwable $e) {
            Log::warning('Scoring commerce indisponible', ['id' => $commerceId, 'msg' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * Recalcule le score d'un service a partir de ses commentaires.
     */
    public function rescoreService(int $serviceId): ?array
    {
        $base = $this->baseUrl();
        if (!$base) {
            return null;
        }

        try {
            $resp = $this->client()->post(rtrim($base, '/') . "/service/{$serviceId}");
            if ($resp->successful()) {
                return $resp->json();
            }
            Log::warning('Scoring service echoue', ['id' => $serviceId, 'status' => $resp->status()]);
        } catch (\Throwable $e) {
            Log::warning('Scoring service indisponible', ['id' => $serviceId, 'msg' => $e->getMessage()]);
        }

        return null;
    }
}
