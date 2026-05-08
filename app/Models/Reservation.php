<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'service_id',
        'sub_service_id',
        'client_name',
        'phone',
        'email',
        'reservation_date',
        'reservation_time',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function subService()
    {
        return $this->belongsTo(SubService::class);
    }
}