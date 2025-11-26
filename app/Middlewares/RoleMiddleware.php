<?php

namespace Middlewares;

use Src\Request;
use Src\Auth\Auth;

class RoleMiddleware
{
    public function handle(Request $request, string $role = null)
    {
        $user = Auth::user();

        if (!$user) {
            app()->route->redirect('/login');
        }

        if ($role && $user->role !== $role && $user->role !== 'admin') {
            app()->route->redirect('/hello');
        }
    }
}