<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function register($data)
    {
        return User::create($data);
    }

    public function getAllUsers()
    {
        return User::get();
    }
}
