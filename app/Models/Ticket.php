<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  

    use HasFactory;

    public $timestamps = false; // Disable automatic timestamps
    public function index()
    {
        // Fetch all tickets without ordering
        $tickets = Ticket::with('branch')->get();
        return view('tickets.index', compact('tickets'));
    }
    

    protected $fillable = [
        'subject', 'description', 'created_by', 'branch_id',
        'priority', 'closeup_date', 'status', 'assign_to'
    ];
   
    public function branch()
    {
        return $this->belongsTo(BranchDetails::class, 'branch_id', 'branch_id');
    }
}

