<?php

use Src\Route;

// Основные маршруты
Route::add('GET', '/', [Controller\Site::class, 'hello']);
Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add(['GET', 'POST'], '/posts/create', [Controller\Site::class, 'createPost'])->middleware('auth');
Route::add('GET', '/posts', [Controller\Site::class, 'posts'])->middleware('auth');

// Здания
Route::add(['GET', 'POST'], '/buildings', [Controller\BuildingController::class, 'index']);
Route::add(['GET', 'POST'], '/buildings/add', [Controller\BuildingController::class, 'add']);
Route::add(['GET', 'POST'], '/buildings/edit/{id}', [Controller\BuildingController::class, 'edit']);
Route::add('POST', '/buildings/delete/{id}', [Controller\BuildingController::class, 'delete']);

// Помещения
Route::add('GET', '/rooms', [Controller\RoomController::class, 'rooms']);
Route::add(['GET', 'POST'], '/rooms/add', [Controller\RoomController::class, 'addRoom']);
Route::add(['GET', 'POST'], '/rooms/edit/{id}', [Controller\RoomController::class, 'editRoom']);
Route::add('POST', '/rooms/delete/{id}', [Controller\RoomController::class, 'deleteRoom']);