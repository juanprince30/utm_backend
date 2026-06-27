<?php

use App\Models\Commerce;
use App\Services\ScoringService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Recalcule le scoring IA (1 a 5) de tous les commerces a partir des commentaires.
Artisan::command('scoring:rescore {commerce? : ID d\'un commerce precis}', function (?int $commerce = null) {
    $scoring = app(ScoringService::class);

    $ids = $commerce
        ? [$commerce]
        : Commerce::pluck('id')->all();

    $this->info('Scoring de ' . count($ids) . ' commerce(s)...');
    foreach ($ids as $id) {
        $res = $scoring->rescoreCommerce($id);
        $score = $res['score'] ?? '—';
        $this->line("  Commerce #{$id} : {$score}/5");
    }
    $this->info('Termine.');
})->purpose('Recalcule le scoring IA des commerces via les commentaires');
