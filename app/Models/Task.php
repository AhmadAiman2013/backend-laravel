<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['card_id', 'title', 'order', 'completed', 'due_date'];

    function card() : BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
