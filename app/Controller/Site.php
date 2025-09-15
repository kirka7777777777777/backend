<?php

namespace Controller;

use Model\Post;
use Src\View;
use Src\Request;
use Model\User;
use Src\Auth\Auth;
use Src\Validator\Validator;
use Src\Traits\FileUploadTrait;

class Site
{

    use FileUploadTrait;

    public function index(Request $request): string
    {
        $posts = Post::where('id', $request->id)->get();
        return (new View())->render('site.post', ['posts' => $posts]);
    }

    public function hello(): string
    {
        // Получаем текущего аутентифицированного пользователя
        $user = app()->auth::user();

        return new View('site.hello', [
            'message' => 'hello working',
            'avatar' => $user->avatar // Передаем аватар в представление
        ]);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required'],
                'avatar' => ['image', 'file_size:2'] // Максимум 2MB
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально',
                'image' => 'Поле :field должно быть изображением',
                'file_size' => 'Поле :field должно быть меньше :max_size MB'
            ]);

            if ($validator->fails()) {
                return new View('site.signup',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            $data = $request->all();

            // Загрузка аватара
            if (!empty($request->files['avatar'])) {
                $uploadPath = app()->settings->getUploadPath();
                $avatar = $this->uploadFile($request->files['avatar'], $uploadPath);
                if ($avatar) {
                    $data['avatar'] = $avatar;
                }
            }

            if (User::create($data)) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }

    public function createPost(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'title' => ['required'],
                'content' => ['required'],
                'image' => ['image', 'file_size:5'] // Максимум 5MB
            ], [
                'required' => 'Поле :field пусто',
                'image' => 'Поле :field должно быть изображением',
                'file_size' => 'Поле :field должно быть меньше :max_size MB'
            ]);

            if ($validator->fails()) {
                return new View('site.createPost',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            $data = $request->all();

            // Загрузка изображения
            if (!empty($request->files['image'])) {
                $uploadPath = app()->settings->getUploadPath();
                $image = $this->uploadFile($request->files['image'], $uploadPath);
                if ($image) {
                    $data['image'] = $image;
                }
            }

            if (Post::create($data)) {
                app()->route->redirect('/posts');
            }
        }
        return new View('site.createPost');
    }

    public function posts(Request $request): string
    {
        $posts = Post::all();
        return (new View())->render('site.posts', ['posts' => $posts]);
    }


    public function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
    
}