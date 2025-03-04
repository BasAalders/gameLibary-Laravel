<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGames extends Model
{
    protected $fillable = [
        'user_id',
        'game_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Game
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
