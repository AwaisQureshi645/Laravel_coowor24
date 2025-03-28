<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
class Admin extends Authenticatable
{
    use HasFactory;
    protected $table = 'admin';
    protected $fillable = ['username', 'password', 'role'];
    protected $hidden = ['password'];
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
