<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'google_event_id',
        'summary',
        'description',
        'location',
        'start',
        'end',
        'room_type',
        'team_name',
        'point_of_contact',
    ];
}
