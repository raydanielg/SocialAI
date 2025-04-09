<?php

namespace App\Models;

use App\Models\KycMethod;
use App\Helpers\PlanPerks;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected static function boot()
    {
        parent::boot();
        // assign the username
        static::creating(function ($user) {
            $isNameUnique = User::where('name', $user->name)->count();
            $username = Str::of($user->name)
                ->trim()
                ->lower()
                ->replace(' ', '')
                ->append($isNameUnique > 0 ? $isNameUnique . Str::random(2) : '');

            $user->username = Str::slug($username);
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'address',
        'avatar',
        'password',
        'role',
        'meta',
        'category_id',
        'status',
        'kyc_verified_at',
        'email_verified_at',
        'credits',
        'provider',
        'provider_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'kyc_verified_at' => 'datetime',
        'status' => 'boolean',
        'meta' => 'array',
        'plan_data' => 'array',
    ];

    protected $appends = ['created_at_date'];

    public function getCreatedAtDateAttribute()
    {
        return $this->created_at?->format('d F Y');
    }

    public static function getpermissionGroups()
    {
        $permission_groups = DB::table('permissions')
            ->select('group_name as name')
            ->groupBy('group_name')
            ->get();
        return $permission_groups;
    }

    public static function getPermissionGroup()
    {
        return $permission_groups = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();
    }
    public static function getpermissionsByGroupName($group_name)
    {
        $permissions = DB::table('permissions')
            ->select('name', 'id')
            ->where('group_name', $group_name)
            ->get();
        return $permissions;
    }

    public static function roleHasPermissions($role, $permissions)
    {
        $hasPermission = true;
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
                return $hasPermission;
            }
        }
        return $hasPermission;
    }

    public function app()
    {
        return $this->hasOne('App\Models\App', 'user_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id');
    }

    public function subscription()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function smstransaction()
    {
        return $this->hasMany('App\Models\Smstransaction');
    }

    public function device()
    {
        return $this->hasMany('App\Models\Device');
    }

    public function kycMethods(): BelongsToMany
    {
        return $this->belongsToMany(KycMethod::class)->withPivot('kyc_request_id');
    }


    //scopes
    public function scopeAdmins($query): Builder // Admins list
    {
        return $query->where('role', 'admin');
    }

    public function scopeUser($query): Builder //Candidates list
    {
        return $query->where('role', 'user');
    }

    public function scopeActive($query): Builder
    {
        return $query->where('status', 1);
    }

    public function scopeInActive($query): Builder
    {
        return $query->where('status', '!=', 1);
    }

    public function scopeVerified($query): Builder
    {
        return $query->where('kyc_verified_at', '!=', null);
    }

    // helper methods

    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->id == 1 && $this->isAdmin();
    }

    public function getDashboardRoute(): string // route name
    {
        return match ($this->role) {
            'admin' => 'admin.dashboard',
            'user' => 'user.dashboard',
            default => 'login',
        };
    }

    /**
     * Formate date for this model datetime attributes
     */
    public function formatedDateFor($attr = 'created_at', $format = 'd M, Y h:i a'): string
    {
        return $this->$attr ? now()->make($this->$attr)->format($format) : '';
    }

    public function aiTemplates(): BelongsToMany
    {
        return $this->belongsToMany(AiTemplate::class);
    }

    public function aiGeneratedContents(): HasMany
    {
        return $this->hasMany(AiGenerate::class);
    }

    public function brand(): hasMany
    {
        return $this->hasMany(Brand::class);
    }

    public function platforms(): hasMany
    {
        return $this->hasMany(UserPlatform::class, 'user_id');
    }

    public function brandPosts(): hasMany
    {
        return $this->hasMany(BrandPost::class);
    }

    public function assets(): hasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function brandPlatforms(): hasMany
    {
        return $this->hasMany(BrandPostPlatform::class);
    }

    public function brands(): hasMany
    {
        return $this->hasMany(Brand::class);
    }
    public function creditHistory(): HasMany
    {
        return $this->hasMany(CreditHistory::class);
    }

    // helper
    public function validatePlan(string $planKey, bool $toArray = false)
    {
        return PlanPerks::checkPlan($planKey, $toArray);
    }
}
