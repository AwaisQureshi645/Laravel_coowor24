<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BranchDetails;
class HuddleRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'branch_id',
    ];

    public function branch()
    {
        return $this->belongsTo(BranchDetails::class, 'branch_id', 'branch_id');

    }
}
