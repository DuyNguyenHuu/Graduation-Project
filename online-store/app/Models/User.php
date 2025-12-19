<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'IdUser';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['IdUser', 'Name', 'email', 'password', 'Phone', 'Status','ROLE', 'created_at', 'updated_at'];
    public function getAuthIdentifierName()
    {
        return 'IdUser';
    }
    public function getNameAttribute()
    {
        return $this->attributes['Name'] ?? null;
    }
}