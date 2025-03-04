<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name',
        'mainImage',
        'releaseDate',
        'releaseDate',
        'rating',
        'Esrb rating',
        'genre',
        'platform',
        'store',
        'screenshots'
    ];

    public function wishlistedByUsers()
    {
        return $this->hasMany(UserGames::class);
    }
}
