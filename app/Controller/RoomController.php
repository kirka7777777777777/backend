<?php
namespace Controller;

use Model\Room;
use Model\Building;
use Model\RoomType;
use Src\View;
use Src\Request;
use Src\Validator\Validator;

class RoomController
{
    public function rooms(Request $request): string
    {
        $buildingId = $request->get('building_id');
        $rooms = $buildingId ? Room::where('building_id', $buildingId)->get() : Room::all();

        $buildings = Building::all();
        return new View('rooms.index', ['rooms' => $rooms, 'buildings' => $buildings]);
    }

    public function addRoom(Request $request): string
    {
        // Доступ только для сотрудников и администраторов
        if (!app()->auth::check() || (!app()->auth::user()->isEmployee() && !app()->auth::user()->isAdmin())) {
            app()->route->redirect('/login');
            return '';
        }

        $buildings = Building::all();
        $types = RoomType::all();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'building_id' => ['required'],
                'type_id' => ['required'],
                'area' => ['required', 'numeric'],
                'seats' => ['required', 'numeric']
            ], [
                'required' => 'Поле :field пусто',
                'numeric' => 'Поле :field должно быть числом'
            ]);

            if ($validator->fails()) {
                return new View('rooms.add', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'buildings' => $buildings,
                    'types' => $types
                ]);
            }

            if (Room::create($request->all())) {
                app()->route->redirect('/rooms');
                return '';
            }
        }
        return new View('rooms.add', ['buildings' => $buildings, 'types' => $types]);
    }

    public function stats(Request $request): string
    {
        $buildingId = $request->get('building_id');

        if ($buildingId) {
            $stats = Room::where('building_id', $buildingId)
                ->selectRaw('SUM(area) as total_area, SUM(seats) as total_seats')
                ->first();
            $building = Building::find($buildingId);
        } else {
            $stats = Room::selectRaw('SUM(area) as total_area, SUM(seats) as total_seats')
                ->first();
            $building = null;
        }

        $buildings = Building::all();
        return new View('rooms.stats', [
            'stats' => $stats,
            'buildings' => $buildings,
            'selectedBuilding' => $building
        ]);
    }
}