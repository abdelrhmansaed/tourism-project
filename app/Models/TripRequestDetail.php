<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripRequestDetail extends Model
{
    use HasFactory;
    protected $fillable = ['trip_request_id', 'total_people', 'male_count', 'female_count', 'price', 'image'];

    public function tripRequest()
    {
        return $this->belongsTo(TripRequest::class);
    }
}
