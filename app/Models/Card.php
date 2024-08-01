<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['title', 'boards_id', 'order'];

    public function board() : BelongsTo
    {
        return $this->belongsTo(Boards::class);
    }

    public function tasks() : HasMany
    {
        return $this->hasMany(Task::class);
    }
}
