<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomCategory;

class Rooms extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_no',
        'category',
        'status',
        'alloted_to'
    ];

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class);
    }
}
