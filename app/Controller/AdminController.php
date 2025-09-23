<?php
namespace Controller;

use Model\User;
use Src\View;
use Src\Request;
use Src\Validator\Validator;
use Src\Auth\Auth;

class AdminController
{
    public function users(Request $request): string
    {
        // Доступ только для администраторов
        if (!app()->auth::user()->isAdmin()) {
            app()->route->redirect('/hello');
            return '';
        }

        $users = User::all();
        return new View('admin.users', ['users' => $users]);
    }

    public function addUser(Request $request): string
    {
        if (!app()->auth::user()->isAdmin()) {
            app()->route->redirect('/hello');
            return '';
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required'],
                'role' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if ($validator->fails()) {
                return new View('admin.addUser',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            $data = $request->all();
            $data['password'] = md5($data['password']);

            if (User::create($data)) {
                app()->route->redirect('/admin/users');
                return '';
            }
        }
        return new View('admin.addUser');
    }
}