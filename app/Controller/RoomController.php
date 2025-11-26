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
    public function index(Request $request): string
    {
        app()->route->redirect('/rooms');
        return '';
    }

    public function rooms(Request $request): string
    {
        $buildingId = $request->get('building_id');
        $rooms = $buildingId ? Room::where('building_id', $buildingId)->get() : Room::all();

        $buildings = Building::all();

        // Статистика для карточек
        $totalRooms = Room::count();
        $totalAuditoriums = Room::whereHas('type', function($query) {
            $query->where('name', 'like', '%аудитория%');
        })->count();
        $totalSeats = Room::sum('seats');

        $view = new View('rooms.index', [
            'rooms' => $rooms,
            'buildings' => $buildings,
            'totalRooms' => $totalRooms,
            'totalAuditoriums' => $totalAuditoriums,
            'totalSeats' => $totalSeats
        ]);
        return (string)$view;
    }

    public function addRoom(Request $request): string
    {
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
                'area' => ['required'],
                'seats' => ['required']
            ], [
                'required' => 'Поле :field пусто'
            ]);

            $additionalErrors = [];

            if (!is_numeric($request->get('area'))) {
                $additionalErrors['area'][] = 'Поле площадь должно быть числом';
            }

            if (!is_numeric($request->get('seats'))) {
                $additionalErrors['seats'][] = 'Поле посадочные места должно быть числом';
            }

            if ($validator->fails() || !empty($additionalErrors)) {
                $allErrors = array_merge($validator->errors(), $additionalErrors);
                $view = new View('rooms.add', [
                    'message' => json_encode($allErrors, JSON_UNESCAPED_UNICODE),
                    'buildings' => $buildings,
                    'types' => $types
                ]);
                return (string)$view;
            }

            if (Room::create($request->all())) {
                $buildingId = $request->get('building_id');
                $building = Building::find($buildingId);
                if ($building) {
                    $building->updateRoomCount();
                }

                app()->route->redirect('/rooms');
                return '';
            }
        }

        $view = new View('rooms.add', ['buildings' => $buildings, 'types' => $types]);
        return (string)$view;
    }

    public function editRoom($id = null, Request $request = null): string
    {
        // Если $request не передан, создаем его
        if ($request === null) {
            $request = app()->request;
        }

        if (!app()->auth::check() || (!app()->auth::user()->isEmployee() && !app()->auth::user()->isAdmin())) {
            app()->route->redirect('/login');
            return '';
        }

        // Получаем ID помещения из параметра маршрута
        $roomId = $id;
        $room = Room::find($roomId);

        $buildings = Building::all();
        $types = RoomType::all();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'building_id' => ['required'],
                'type_id' => ['required'],
                'area' => ['required'],
                'seats' => ['required']
            ], [
                'required' => 'Поле :field пусто'
            ]);

            // Дополнительная проверка на числовые значения
            $additionalErrors = [];

            if (!is_numeric($request->get('area'))) {
                $additionalErrors['area'][] = 'Поле площадь должно быть числом';
            }

            if (!is_numeric($request->get('seats'))) {
                $additionalErrors['seats'][] = 'Поле посадочные места должно быть числом';
            }

            // Объединяем ошибки
            if ($validator->fails() || !empty($additionalErrors)) {
                $allErrors = array_merge($validator->errors(), $additionalErrors);
                $view = new View('rooms.edit', [
                    'message' => json_encode($allErrors, JSON_UNESCAPED_UNICODE),
                    'room' => $room,
                    'buildings' => $buildings,
                    'types' => $types
                ]);
                return (string)$view;
            }

            if ($room) {
                $oldBuildingId = $room->building_id;
                $newBuildingId = $request->get('building_id');
                $room->update($request->all());

                if ($oldBuildingId != $newBuildingId) {
                    $oldBuilding = Building::find($oldBuildingId);
                    if ($oldBuilding) {
                        $oldBuilding->updateRoomCount();
                    }
                }

                $newBuilding = Building::find($newBuildingId);
                if ($newBuilding) {
                    $newBuilding->updateRoomCount();
                }

                app()->route->redirect('/rooms');
                return '';
            }
        }

        $view = new View('rooms.edit', [
            'room' => $room,
            'buildings' => $buildings,
            'types' => $types
        ]);
        return (string)$view;
    }

    public function deleteRoom($id = null, Request $request = null): string
    {
        if ($request === null) {
            $request = app()->request;
        }

        if (!app()->auth::check() || (!app()->auth::user()->isEmployee() && !app()->auth::user()->isAdmin())) {
            app()->route->redirect('/login');
            return '';
        }

        $roomId = $id;
        $room = Room::find($roomId);

        if ($room) {
            $buildingId = $room->building_id;
            $room->delete();

            $building = Building::find($buildingId);
            if ($building) {
                $building->updateRoomCount();
            }
        }

        app()->route->redirect('/rooms');
        return '';
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

        $view = new View('rooms.stats', [
            'stats' => $stats,
            'buildings' => $buildings,
            'selectedBuilding' => $building
        ]);
        return (string)$view;
    }
}