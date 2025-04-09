<?php

namespace Modules\Videoai\App\Models;

use App\Models\AiGenerate;
use App\Models\CreditHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PromptPreset extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'meta' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function generates(): MorphMany
    {
        return $this->morphMany(AiGenerate::class, 'generatable');
    }
    public function credit_histories(): MorphMany
    {
        return $this->morphMany(CreditHistory::class, 'creditable');
    }
}
