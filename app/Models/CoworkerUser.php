<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CoworkerUser extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $table = 'coworker_users';
    protected $primaryKey = 'coworker_users_id';
    
    protected $fillable = [
        'CNIC',
        'username',
        'email',
        'password',
        'phonenumber',
        'role',
        
        'branch_id',
        'cnic',
    'address',
    'cnic_pic'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function branch()
    {
        return $this->belongsTo(BranchDetails::class, 'branch_id', 'branch_id');
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}







