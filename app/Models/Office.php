<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'RoomNo',
        'capacity',
        'Price',
        'branch_id',
        'status'
    ];

    public function branch()
    {
        return $this->belongsTo(BranchDetails::class, 'branch_id', 'branch_id');
    }
}
