<?php

namespace App\Models;

use App\Helpers\ModelHelper;
use App\Helpers\ModelHelperConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory, ModelHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'name',
        'email',
        'phone',
        'address',
        'linkedin_profile',
        'website',
        'experience',
        'expected_salary',
        'note',
        'cv',
    ];

    public function modelHelperConfig(): ModelHelperConfig
    {
        return ModelHelperConfig::create()
            ->files(['cv']);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
