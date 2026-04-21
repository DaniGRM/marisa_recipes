<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Room;

class AssociateIcons extends Command
{
    protected $signature = 'rooms:icons';
    protected $description = 'Asocia íconos a las habitaciones';

    public function handle()
    {
        $icons = [
            'Salón' => 'icons/rooms/tv.png',
            'Cocina' => 'icons/rooms/kitchen.png',
            'Baño' => 'icons/rooms/bath.png',
            'Dormitorio' => 'icons/rooms/bed.png',
            'Galería' => 'icons/rooms/laundry.png',
            'Mascotas' => 'icons/rooms/pets.png',
        ];

        $rooms = Room::all();

        foreach ($rooms as $room) {
            if (isset($icons[$room->name])) {
                $room->icon_path = $icons[$room->name];
                $room->save();
                $this->info("Ícono asociado a la habitación: {$room->name}");
            } else {
                $this->warn("No se encontró un ícono para la habitación: {$room->name}");
            }
        }
        return 0;
    }
}