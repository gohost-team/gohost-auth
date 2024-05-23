<?php

namespace GohostAuth\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

const ACTIVE_TOKEN_LIFETIME = 24 * 60 * 60; // 1 day

class User extends Authenticatable implements JWTSubject
{    
    // =========================================================
    // Helper
    // =========================================================

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
        return [
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'tenants' => $this->hasProducts(),
        ];
    }
}
