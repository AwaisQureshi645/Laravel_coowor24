<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id';
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'username',
        'password',
        'email',
        'role',
        'CNIC-pic'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Add password hashing mutator
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}