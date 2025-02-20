<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'flight_number', 'location', 'start_time', 'end_time'];
}

?>