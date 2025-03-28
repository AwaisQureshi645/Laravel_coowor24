<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualCoworker extends Model
{
    //

    use HasFactory;
    protected $table = 'individual_coworkers';
    protected $primaryKey = 'coworker_id';
    protected $fillable = [
        'name',
        'contact_info',
        'email',
        'branch_id',
        'seat_type',
        'private_office_size',
        'no_of_seats',
        'joining_date',
        'contract_copy',
    ];

    public function branch()
    {
        return $this->belongsTo(BranchDetails::class, 'branch_id', 'branch_id');
    }
}
