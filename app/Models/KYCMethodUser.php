<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class KYCMethodUser extends Pivot
{
    protected $table = 'kyc_method_user';

    public function users()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }

    public function methods()
    {
        return $this->hasMany(KycMethod::class, 'kyc_method_id', 'id');
    }
}
