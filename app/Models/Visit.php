<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $table = 'visitorsinfo';

    protected $fillable = [
        'purpose',
        'name',
        'email',
        'businessDetails',
        'phonenumber',
        'assignedTo',
        'branch_id',
        'Comments',
        'appointment_date',
    ];

    public function branch()
    {
        return $this->belongsTo(BranchDetails::class, 'branch_id', 'branch_id');
    }
}

