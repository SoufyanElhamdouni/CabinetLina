<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    protected $fillable = [
        'service_id',
        'name',
        'description',
        'duration_minutes',
        'price',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
