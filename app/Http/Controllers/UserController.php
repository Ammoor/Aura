<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponseFormat;
use App\Http\Requests\UserLogInRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function login(UserLogInRequest $request)
    {
        // $userToken['userToken'] = $this->userService->logIn($request->validated());
        $this->userService->logIn($request->validated());
        return ApiResponseFormat::successResponse(200, 'User logged in successfully.', $userToken);
    }
    public function register(UserRegisterRequest $request)
    {
        $userToken['userToken'] = $this->userService->register($request->validated());
        return ApiResponseFormat::successResponse(201, 'User registered successfully.', $userToken);
    }
    public function logOut()
    {
        $this->userService->logOut();
        return ApiResponseFormat::successResponse(200, 'User logged out successfully.');
    }
}
