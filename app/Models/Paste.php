<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Comment;
use App\Models\User;

class Paste extends Model
{
    use HasFactory;
    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    protected $fillable = [
        'title',
        'main_text',
        'expiration',
        'access',
        'author_id'
    ];
}
