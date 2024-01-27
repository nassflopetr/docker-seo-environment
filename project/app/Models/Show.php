<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Show extends Model
{
    use HasFactory;

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function gallery(): HasMany
    {
        return $this->hasMany(Gallery::class, 'show_id', 'id');
    }
}
