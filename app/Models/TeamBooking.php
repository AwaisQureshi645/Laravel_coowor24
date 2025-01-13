<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamBooking extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'team_name',
        'joining_date',
        'ending_date',
        'security_amount',
        'point_of_contact',
        'num_members',
        'branch_name',
        'reference',
        'contract_copy',
    ];

    public function branch()
    {
        // 'branch_id' in the team_bookings table references 'id' in the branches table
        return $this->belongsTo(Branch::class);
    }

}
