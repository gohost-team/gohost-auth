<?php

namespace GohostAuth\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use GohostAuth\Enums\UserType;
use Illuminate\Support\Str;

const ACTIVE_TOKEN_LIFETIME = 5 * 24 * 60 * 60; // 1 day

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'is_active',        
        'permissions'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'permissions' => 'array',
        'type' => UserType::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($record) {
            $record->email = strtolower($record->email);
            $record->gh_id = (string) Str::uuid();

            if (! $record->password) {
                $record->password = bcrypt(Str::random(10));
            }
            if (! $record->type) {
                $record->type = UserType::Customer;
            }
        });        
    }

    // =========================================================
    // Helper
    // =========================================================

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isAdmin(): bool
    {
        return $this->type === UserType::Admin;
    }

    public function isGHUser(): bool
    {
        return $this->type === UserType::GoHost || $this->type === UserType::Admin;
    }

    public function isCustomer(): bool
    {
        return $this->type == UserType::Customer;
    }    

    // =========================================================
    // JWT Token
    // =========================================================

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        $model = config('gh-auth.user_model');
        return [
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'gh_id' => $this->gh_id,
            'is_active' => $this->is_active,
            'permissions' => $model::buildPermissions()
        ];
    }
}