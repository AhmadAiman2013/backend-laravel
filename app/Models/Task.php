<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['card_id', 'title', 'order', 'completed', 'due_date'];

    public function scopeOrdered(Builder $query) : Builder
    {
        return $query->orderBy('order');
    }

    function card() : BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
