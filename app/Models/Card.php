<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'boards_id', 'order'];

    public function board()
    {
        return $this->belongsTo(Boards::class);
    }
}
