<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomCategory;

class RoomsController extends Controller
{
    public function availability(Request $request)
    {

        $request->validate([
            'checkIn' => 'required|date',
            'checkOut' => 'required|date',
        ]);

        $data = [];


        // get all room categories
        $roomCategories = RoomCategory::all();

        foreach ($roomCategories as $roomCategory) {
            $data[$roomCategory->slug] = [
                'category' => $roomCategory->name,
                'id' => $roomCategory->slug,
                'name' => $roomCategory->name,
                'price' => $roomCategory->price,
                'maxAdults' => $roomCategory->maxAdults,
                'maxChildren' => $roomCategory->maxChildren,
                'maxInfants' => $roomCategory->maxInfants,
                'maxOccupancy' => $roomCategory->maxOccupancy,
                'mealPlans' => $roomCategory->mealPlans,
                'availableRooms' => $roomCategory->availableRooms->count(),
                'totalRooms' => $roomCategory->rooms->count(),
            ];
        }

        // TODO: get from database after some time
        return response()->json([
            'data' => $data,
        ]);
    }

    public function booking(Request $request)
    {
        $request->validate([
            'bookings' => 'required',
            'discount' => 'required',
        ]);

        // loop over bookings
        // check if room is available
        // if available, book it
        // if not available, return error




        return response()->json([
            'data' => [
                'message' => 'Booking successful',
            ],
        ]);
    }
}
