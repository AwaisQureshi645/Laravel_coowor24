<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    protected $primaryKey = 'seat_id';
    protected $fillable = [
        'seat_number', 'branch_id', 'status', 'coworker_id',
    ];

    public function branch()
    {
        return $this->belongsTo(BranchDetails::class, 'branch_id', 'branch_id');
    }

    public function coworker()
    {
        return $this->belongsTo(IndividualCoworker::class, 'coworker_id', 'coworker_id');
    }
  
}
