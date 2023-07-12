<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use MilanTarami\ApiResponseBuilder\Facades\ResponseBuilder;

class AuthController extends Controller
{
    /**
     * Create User
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = User::query()->create($request->validated());
            return ResponseBuilder::asSuccess()
                ->withData($user)
                ->append('token', $user->createToken("API TOKEN")->plainTextToken)
                ->build();

        } catch (Exception $exception) {
            return ResponseBuilder::error($exception);
        }
    }

    /**
     * Login The User
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            if(!Auth::attempt($request->only(['email', 'password']))){
                return ResponseBuilder::asError()
                    ->withMessage('Email & Password does not match with our record.')
                    ->build();
            }
            $user = User::where('email', $request->email)->first();
            return ResponseBuilder::asSuccess()
                ->append('token', $user->createToken("API TOKEN")->plainTextToken)
                ->build();
        } catch (Exception $exception) {
            return ResponseBuilder::error($exception);
        }
    }
}
