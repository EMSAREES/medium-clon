<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Clap extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'count',
    ];

    /**
     * El post que recibió este aplauso.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * El usuario que aplaudió.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
