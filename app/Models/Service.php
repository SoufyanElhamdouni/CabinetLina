<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration_minutes',
        'price',
        'image',
    ];

    public function subServices()
{
    return $this->hasMany(SubService::class);
}
}