<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'name',
        'date',
        'type',
        'description',
    ];

    public function tripRequests()
    {
        return $this->hasMany(TripRequest::class);
    }

}
