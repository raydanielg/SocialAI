<?php

namespace App\Models;

use App\Helpers\ModelHelper;
use App\Helpers\ModelHelperConfig;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Brand extends Model
{
    use HasFactory, ModelHelper, HasFilter;

    protected $guarded = [];
    protected $casts = [
        'identities' => 'array',
        'color' => 'array',
        'audiences' => 'array',
        'strategy' => 'array',
        'voices' => 'array',
    ];

    public function modelHelperConfig(): ModelHelperConfig
    {
        return ModelHelperConfig::create()
            ->generateUuid()
            ->files(['logo']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
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
