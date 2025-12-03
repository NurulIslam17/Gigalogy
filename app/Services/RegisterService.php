<?php

namespace App\Services;

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
        return  $this->userRepository->register($data);
    }
}
