<?php

namespace GohostAuth\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use GohostAuth\Enums\UserType;
use GohostAuth\Enums\UserStatus;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use GohostAuth\Mail\Auth\ActiveAccount;
use GohostAuth\Mail\Auth\ResetPassword;

const ACTIVE_TOKEN_LIFETIME = 5 * 24 * 60 * 60; // 5 days

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'gh_id',
        'is_active',        
        'permissions',
        'active_token'
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

            if (! $record->status) {                
                $record->status = UserStatus::Pending;
            }
        });

        static::created(function ($record) {
            $record->setActiveToken(true);
            $record->sendInvitation();
        });
    }

    // =========================================================
    // SCOPE
    // =========================================================

    public function scopeType($query, $type): void
    {
        if (is_array($type)) {
            $query->whereIn('type', $type);
        } else {
            $query->where('type', $type);
        }        
    }

    // =========================================================
    // ACTIVATION
    // =========================================================

    public function sendInvitation()
    {
        if ($this->type == UserType::GoHost) {
            Mail::to($this->email)->queue(new ActiveAccount($this));
        }
    }

    public function sendResetPasswordEmail()
    {
        $this->setActiveToken();
        Mail::to($this->email)->queue(new ResetPassword($this));
    }

    public function setActiveToken($force = false)
    {
        $needNewToken = true;

        if (! $force && $this->active_token) {
            $decodedToken = base64_decode($this->active_token);
            $expirationTime = explode('|', $decodedToken)[0];
            if ($expirationTime > time()) {
                $needNewToken = false;
            }
        }

        // Generate new token
        if ($needNewToken) {
            $expirationTime = time() + ACTIVE_TOKEN_LIFETIME;
            $token = str_replace('|', '', Str::random(30));
            $this->active_token = base64_encode("{$expirationTime}|{$token}");
            $this->saveQuietly();
        }
    }

    public function canActivable(): bool
    {
        $canActivable = $this->status == UserStatus::Pending ||
            $this->status == UserStatus::Inactive;

        if ($canActivable) {
            $this->setActiveToken();
        }        

        return $canActivable;
    }

    public function activeAccount($password)
    {
        $this->password = bcrypt($password);
        $this->status = UserStatus::Active;
        $this->is_active = true;
        $this->setActiveToken(true);

        $this->save();
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


    public function getAuthIdentifierName()
    {
        return "gh_id";
    }

    // =========================================================
    // JWT Token
    // =========================================================

    public function getJWTIdentifier()
    {
        return $this->gh_id;
    }

    public function getJWTCustomClaims()
    {
        $model = config('gh-auth.user_model');
        return [
            // 'sub' => $this->gh_id,
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'gh_id' => $this->gh_id,
            'is_active' => $this->is_active,
            'permissions' => $model::buildPermissions()
        ];
    }
}