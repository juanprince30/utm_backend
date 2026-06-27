<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'prenom',
        'isActif',
        'canCormmerce',
        'isCertified',
        'scoringArtisant',
        'role',
        'addresse',
        'telephone',
        'photo',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'isActif'           => 'boolean',
            'canCormmerce'      => 'boolean',
            'isCertified'       => 'boolean',
        ];
    }

    public function commerces(): HasMany
    {
        return $this->hasMany(Commerce::class, 'IdUser');
    }

    public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class, 'IdUser');
    }
}
