<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commentaire extends Model
{
    protected $fillable = [
        'body',
        'idCommerce',
        'idService',
        'IdUser',
    ];

    public function commerce(): BelongsTo
    {
        return $this->belongsTo(Commerce::class, 'idCommerce');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'idService');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'IdUser');
    }
}
