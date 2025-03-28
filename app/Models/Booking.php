<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TeamBooking as Team;	    
use App\Models\MeetingRoom as Room;
use App\Models\BranchDetails as Branch;
class Booking extends Model
{
    use HasFactory;
    protected $primaryKey = 'booking_id';
    protected $fillable = [
        'event_id',
        'team_name',
        'point_of_contact',
        'location',
        'description',
        'start_time',
        'end_time',
        'room_type',
        'room_id',
        'summary',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_name', 'team_name');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'location', 'branch_name'); // Adjust column names as needed
    }
}