<?php

namespace App\Services;

use App\Jobs\SendEmail;
use App\Models\User;
use App\Repositories\UserRepository;

class RegisterService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register($data)
    {
        $user = $this->userRepository->register($data);
        SendEmail::dispatch($user->email);
        return $user;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }
}
