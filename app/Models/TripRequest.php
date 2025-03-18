<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripRequest extends Model
{
    protected $fillable = [
        'trip_id',
        'agent_id',
        'status',
        'provider_id',

    ];
    public $timestamps = false;
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
    public function detail()
    {
        return $this->hasOne(TripRequestDetail::class);
    }
}
