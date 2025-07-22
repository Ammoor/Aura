<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponseFormat;
use App\Http\Requests\UserLogInRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
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
        $userToken =  $this->userService->logIn($request->validated());
        if ($userToken) {
            return ApiResponseFormat::successResponse(200, 'User logged in successfully.', ['userToken' => $userToken]);
        }
        return ApiResponseFormat::failedResponse(404, 'User credentials does not match DB records.');
    }
    public function register(UserRegisterRequest $request)
    {
        $this->userService->register($request->validated());
        return ApiResponseFormat::successResponse(200, 'Confirmation email sent.');
    }
    public function logOut()
    {
        $this->userService->logOut();
        return ApiResponseFormat::successResponse(200, 'User logged out successfully.');
    }
    public function getUserData()
    {
        $user = $this->userService->getUserData();
        return ApiResponseFormat::successResponse(200, 'User data returned successfully.', new UserResource($user));
    }
    public function updateUserData(UserUpdateRequest $request)
    {
        $this->userService->updateUserData($request->validated());
        return ApiResponseFormat::successResponse(200, 'User data updated successfully.');
    }
    public function deleteUserData()
    {
        $this->userService->deleteUserData();
        return ApiResponseFormat::successResponse(200, 'User deleted successfully.');
    }
}
