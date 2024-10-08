<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Boards extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['title', 'user_id'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cards() : HasMany
    {
        return $this->hasMany(Card::class)->ordered();
    }
}
