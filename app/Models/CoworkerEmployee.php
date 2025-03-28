<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoworkerEmployee extends Model
{
    use HasFactory;

    protected $table = 'coworker_employees';
    protected $primaryKey = 'coworker_employees_id';
    protected $fillable = [
        'username',
        'email',
        'password',
        'phonenumber',
        'role',
        'branch_id',
        'cnic',
        'address',
        'cnic_pic',
    ];

    public function branch()
    {
        return $this->belongsTo(BranchDetails::class, 'branch_id', 'branch_id');
    }
}
