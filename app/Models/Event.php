<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'scheduled_time',
        'capacity',
        'price',
        'status',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];
    public function images()
    {
        return $this->hasMany(EventImage::class);
    }

    public function headImage()
    {
        return $this->hasOne(EventImage::class)->where('is_head', true);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'joins')->withTimestamps();
    }
}
