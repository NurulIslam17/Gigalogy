<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Http\Requests\RegisterUserRequest;
use App\Services\RegisterService;

class RegisterController extends Controller
{
    use ApiResponse;
    protected $registerService;
    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->registerService->register($request->validated());
        if ($user) {
            return $this->successResponse($user, 'User registered successfully');
        }
        return $this->errorResponse('Registration failed', [], 500);
    }
    public function getAllUsers()
    {
        $user = $this->registerService->getAllUsers();
        return $this->successResponse($user, 'User fetched successfully');
    }
}
