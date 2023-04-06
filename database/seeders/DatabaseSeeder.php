<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoomCategory;
use App\Models\Rooms;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 4 room categories [Standard Room,Executive Suite Room,Deluxe Room,Mixed Room]
        $roomCategories = [
            [
                'name' => 'Standard Room',
                'slug' => 'standard-room',
                'price' => 100,
                'maxAdults' => 2,
                'maxChildren' => 2,
                'maxInfants' => 2,
                'maxOccupancy' => 6,
                'mealPlans' => [
                    'Room Only',
                    'In Lounge',
                ],
            ],
            [
                'name' => 'Executive Suite Room',
                'slug' => 'executive-suite-room',
                'price' => 200,
                'maxAdults' => 2,
                'maxChildren' => 2,
                'maxInfants' => 2,
                'maxOccupancy' => 6,
                'mealPlans' => [
                    'Room Only',
                    'In Lounge',
                ],
            ],
            [
                'name' => 'Deluxe Room',
                'slug' => 'deluxe-room',
                'price' => 300,
                'maxAdults' => 2,
                'maxChildren' => 2,
                'maxInfants' => 2,
                'maxOccupancy' => 6,
                'mealPlans' => [
                    'Room Only',
                    'In Lounge',
                ],
            ],
            [
                'name' => 'Mixed Room',
                'slug' => 'mixed-room',
                'price' => 400,
                'maxAdults' => 2,
                'maxChildren' => 2,
                'maxInfants' => 2,
                'maxOccupancy' => 6,
                'mealPlans' => [
                    'Room Only',
                    'In Lounge',
                ],
            ]
        ];

        foreach ($roomCategories as $roomCategory) {
            // RoomCategory::create($roomCategory);

            $roomCate = new RoomCategory();
            $roomCate->name = $roomCategory['name'];
            $roomCate->slug = $roomCategory['slug'];
            $roomCate->price = $roomCategory['price'];
            $roomCate->maxAdults = $roomCategory['maxAdults'];
            $roomCate->maxChildren = $roomCategory['maxChildren'];
            $roomCate->maxInfants = $roomCategory['maxInfants'];
            $roomCate->maxOccupancy = $roomCategory['maxOccupancy'];
            $roomCate->mealPlans = $roomCategory['mealPlans'];
            $roomCate->save();
        }

        // create 50 rooms with random room category
        $roomCategories = RoomCategory::select('id')->get()->toArray();

        // loop from roomCategories array and get random room category id
        $allotedRoomNo = [];
        foreach ($roomCategories as $roomCategory) {
            // loop 15 times
            for ($i = 0; $i < 15; $i++) {
                $room = new Rooms();
                // check if room no is already alloted or not
                do {
                    $roomNo = rand(100, 999);
                } while (in_array($roomNo, $allotedRoomNo));

                $allotedRoomNo[] = $roomNo;
                $room->room_no = $roomNo;

                $room->category = $roomCategory['id'];
                $room->status = 'available';
                $room->alloted_to = null;
                $room->save();
            }
        }
    }
}
