<?php

namespace App\Models;

use App\Models\BrandPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserPlatform extends Model
{
    use HasFactory;

    const PLATFORMS = ['facebook', 'twitter', 'instagram', 'linkedin', 'tiktok'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'platform_id',
        'platform',

        'name',
        'username',
        'picture',

        'access_token',
        'access_token_expire_at',
        'refresh_token',
        'refresh_token_expire_at',

        'failed_mail_send_at',

        'type',
        'meta',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'json',
        'access_token_expire_at' => 'datetime',
        'refresh_token_expire_at' => 'datetime',
        'failed_mail_send_at' => 'datetime',
    ];

    public function brandContents(): BelongsToMany
    {
        return $this->belongsToMany(BrandPost::class, 'platform_contents', 'user_platform_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
