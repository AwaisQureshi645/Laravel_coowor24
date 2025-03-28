<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchDetails extends Model
{
    use HasFactory;
    protected $table = 'branch_details';
    protected $primaryKey = 'branch_id';
    public $incrementing = true; // Set the custom primary key
    protected $fillable = [
        'branch_name', 
        'location', 
        'contact_details',
        'manager_name',
    ];



    public function seats()
{
    return $this->hasMany(Seat::class, 'branch_id', 'branch_id');
}
}
