<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Paste;

class Comment extends Model
{
    use HasFactory;
    public function paste(): BelongsTo
    {
        return $this->belongsTo(Paste::class);
    }
    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
