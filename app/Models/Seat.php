<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BranchDetails;
use App\Models\IndividualCoworker;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'seat_number',
        'branch_id',
        'status',
        'coworker_id',
        'assign_coworker_name',
    ];

    /**
     * Relationship to BranchDetails.
     */
    public function branch()
    {
        return $this->belongsTo(BranchDetails::class, 'branch_id', 'branch_id');
    }

    /**
     * Relationship to IndividualCoworker.
     */
    public function coworker()
    {
        return $this->belongsTo(IndividualCoworker::class, 'coworker_id', 'coworker_id');
    }
}
