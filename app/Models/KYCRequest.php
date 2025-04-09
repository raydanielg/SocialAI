<?php

namespace App\Models;

use App\Notifications\KYCRequestNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KYCRequest extends Model
{
    use HasFactory;

    protected $table = 'kyc_requests';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = KYCRequest::max('id') + 1;
            $model->request_id = str_pad($model->id, 7, '0', STR_PAD_LEFT);
        });
    }
    protected $fillable = [
        "user_id",
        "kyc_method_id",
        "status",
        "rejected_at",
        "comment",
        "note",
        "data",
        "fields",
        "request_id"
    ];

    protected $casts = [
        'data' => 'array',
        'fields' => 'json'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['created_at_date'];

    public function getCreatedAtDateAttribute()
    {
        return $this->created_at?->format('d F Y');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(KycMethod::class, 'kyc_method_id', 'id');
    }
}
