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
    public function buildings(Request $request): string
    {
        $buildings = Building::with('rooms')->get();
        return new View('buildings.index', ['buildings' => $buildings]);
    }

    public function addBuilding(Request $request): string
    {
        if (!app()->auth::check() || (!app()->auth::user()->isEmployee() && !app()->auth::user()->isAdmin())) {
            app()->route->redirect('/login');
            return '';
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'address' => ['required']
            ], [
                'required' => 'Поле :field пусто'
            ]);

            if ($validator->fails()) {
                return new View('buildings.add',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (Building::create($request->all())) {
                app()->route->redirect('/buildings');
                return '';
            }
        }
        return new View('buildings.add');
    }
}