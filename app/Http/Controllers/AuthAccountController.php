<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Services\UserService;
use App\Http\Requests\AuthAccountsRequest;
use App\Helpers\ApiResponseFormat;

class AuthAccountController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function redirect(AuthAccountsRequest $request)
    {
        return Socialite::driver($request->provider_name)->redirect();
    }
    public function callback(Request $request)
    {
        try {
            $user = Socialite::driver($request->provider_name)->user();
        } catch (Exception $e) {
            return ApiResponseFormat::failedResponse(401, 'Authentication failed.');
        }
        $user->provider_name = $request->provider_name;
        $token = $this->userService->authAccountUser($user);
        // return ApiResponseFormat::successResponse(200, 'User authenticated successfully.',$userToken);
        return redirect()->away("aura://callback?token={$token}");
    }
}
