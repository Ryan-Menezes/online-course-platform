<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserEditController extends Controller
{
    public function __invoke(User $user)
    {
        return view('users.edit', compact('user'));
    }
}
