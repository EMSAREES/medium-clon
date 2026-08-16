<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property int $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post $post
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clap newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clap newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clap query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clap whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clap whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clap whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clap wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clap whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clap whereUserId($value)
 * @mixin \Eloquent
 */
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
