<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commerce extends Model
{
    protected $fillable = [
        'nomCormmercial',
        'categorie',
        'position',
        'ville',
        'description',
        'horaire',
        'emailCommerce',
        'conctactResponsable',
        'etatPublication',
        'lienCommerce',
        'scoringCommerce',
        'photos',
        'IdUser',
    ];

    protected function casts(): array
    {
        return [
            'horaire'         => 'array',
            'photos'          => 'array',
            'etatPublication' => 'string',
            'scoringCommerce' => 'decimal:1',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'IdUser');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'idCommerce');
    }

    public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class, 'idCommerce');
    }
}
