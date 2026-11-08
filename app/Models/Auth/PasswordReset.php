<?php

namespace App\Models\Auth;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordReset extends Model
{
    use SoftDeletes;
    protected $table = 'password_resets';
    protected $fillable = [
        'profile_type',
        'email',
        'token',
        'ip_address',
        'user_agent',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isUsed(): bool
    {
        return $this->used_at != NULL;
    }

    public function markAsUsed():void{
        $this->update(['used_at' => Carbon::now()]);
    }
}
