<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'nomService',
        'description',
        'prixService',
        'isAvaillable',
        'photo',
        'scoringService',
        'idCommerce',
        'etatPublication',
    ];

    protected function casts(): array
    {
        return [
            'isAvaillable'    => 'boolean',
            'prixService'     => 'decimal:2',
            'etatPublication' => 'string',
        ];
    }

    public function commerce(): BelongsTo
    {
        return $this->belongsTo(Commerce::class, 'idCommerce');
    }

    public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class, 'idService');
    }
}
