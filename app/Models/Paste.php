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

    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'title',
        'main_text',
        'access',
        'expiration',
        'user_id',
        'author_id',
    ];

    protected $casts = [
        'access' => 'boolean',
        'expiration' => 'datetime',
        'user_id' => 'integer',
        'author_id' => 'integer',
    ];
}
