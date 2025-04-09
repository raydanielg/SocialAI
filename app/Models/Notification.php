<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'comment',
        'url',
        'seen',
        'for_admin',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'seen' => 'boolean',
        'for_admin' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['created_at_human_date'];

    /**
     * Get the 
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtHumanDateAttribute($value)
    {
        return $this->created_at->diffForHumans();
    }

    public static function sendToAdmin($title, $message, $url = null)
    {
        return self::create([
            'user_id' => null,
            'title' => $title,
            'comment' => $message,
            'url' => $url,
            'seen' => false,
            'for_admin' => true,
        ]);
    }

    public static function sendFromAdmin($user_id, $title, $message, $url = null)
    {
        return self::create([
            'user_id' => $user_id,
            'title' => $title,
            'comment' => $message,
            'url' => $url,
            'seen' => false,
            'for_admin' => false,
        ]);
    }
}
