<?php
namespace Controller;

use Model\Building;
use Model\Room;
use Model\RoomType;
use Src\View;
use Src\Request;
use Src\Validator\Validator;

class BuildingController
{
    public function index(Request $request): string
    {
        $buildings = Building::with('rooms')->get();
        $searchParams = [];

        // Если это POST запрос (поиск), обрабатываем поиск
        if ($request->method === 'POST') {
            $data = $request->all();

            $query = Building::query();

            if (!empty($data['name'])) {
                $query->where('name', 'like', '%' . $data['name'] . '%');
            }
            if (!empty($data['address'])) {
                $query->where('address', 'like', '%' . $data['address'] . '%');
            }

            $buildings = $query->with('rooms')->get();
            $searchParams = [
                'name' => $data['name'] ?? '',
                'address' => $data['address'] ?? ''
            ];
        }

        return (new View('buildings.index', [
            'buildings' => $buildings,
            'search_params' => $searchParams
        ]))->__toString();
    }

    public function add(Request $request): string
    {
        if (!app()->auth::check() || (!app()->auth::user()->isEmployee() && !app()->auth::user()->isAdmin())) {
            app()->route->redirect('/login');
            return '';
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'address' => ['required'],
                'room_count' => ['required', 'numeric', 'min:1']
            ], [
                'required' => 'Поле :field пусто',
                'numeric' => 'Поле :field должно быть числом',
                'min' => 'Поле :field должно быть не менее :min'
            ]);

            if ($validator->fails()) {
                return (new View('buildings.add',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]))->__toString();
            }

            if (Building::create($request->all())) {
                app()->route->redirect('/buildings');
                return '';
            }
        }
        return (new View('buildings.add'))->__toString();
    }

    public function search(Request $request): string
    {
        $query = Building::query();

        if ($request->method === 'POST') {
            // Правильно получаем данные из запроса
            $data = $request->all();

            if (!empty($data['name'])) {
                $query->where('name', 'like', '%' . $data['name'] . '%');
            }
            if (!empty($data['address'])) {
                $query->where('address', 'like', '%' . $data['address'] . '%');
            }
        }

        $buildings = $query->with('rooms')->get();

        return (new View('buildings.index', [
            'buildings' => $buildings,
            'search_params' => [
                'name' => $data['name'] ?? '',
                'address' => $data['address'] ?? ''
            ]
        ]))->__toString();
    }

    public function edit($id, Request $request): string
    {
        if (!app()->auth::check() || (!app()->auth::user()->isEmployee() && !app()->auth::user()->isAdmin())) {
            app()->route->redirect('/login');
            return '';
        }

        $building = Building::find($id);

        if (!$building) {
            app()->route->redirect('/buildings');
            return '';
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'address' => ['required'],
                'room_count' => ['required', 'numeric', 'min:1']
            ], [
                'required' => 'Поле :field пусто',
                'numeric' => 'Поле :field должно быть числом',
                'min' => 'Поле :field должно быть не менее :min'
            ]);

            if ($validator->fails()) {
                return (new View('buildings.edit', [
                    'building' => $building,
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]))->__toString();
            }

            if ($building->update($request->all())) {
                app()->route->redirect('/buildings');
                return '';
            }
        }

        return (new View('buildings.edit', ['building' => $building]))->__toString();
    }

    public function delete($id, Request $request): string
    {
        if (!app()->auth::check() || (!app()->auth::user()->isEmployee() && !app()->auth::user()->isAdmin())) {
            app()->route->redirect('/login');
            return '';
        }

        $building = Building::find($id);

        if ($building) {
            $building->delete();
        }

        app()->route->redirect('/buildings');
        return '';
    }
}