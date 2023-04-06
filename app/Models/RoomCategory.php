<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'maxAdults',
        'maxChildren',
        'maxInfants',
        'maxOccupancy',
        'mealPlans',
    ];

    protected $casts = [
        'mealPlans' => 'array',
    ];

    public function availableRooms()
    {
        return $this->hasMany(Rooms::class, 'category', 'id')->where('status', 'available');
    }

    public function rooms()
    {
        return $this->hasMany(Rooms::class, 'category', 'id');
    }
}
