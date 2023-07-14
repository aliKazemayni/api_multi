<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Libraries\Responder\Facades\ResponderFacade;
use Exception;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
            $user->token = $user->createToken("API TOKEN")->plainTextToken;
            return ResponderFacade::setData($user)->respond();

        } catch (Exception $exception) {
            return ResponderFacade::
                setExceptionMessage($exception->getMessage())
                ->respondError();
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
            $type = 'username';
            if(filter_var($request->username, FILTER_VALIDATE_EMAIL) !== false)
            {
                $type='email';
                $data = [
                    "email" => $request->username,
                    "password" => $request->password
                ];
            }else $data = request()->all();
            if(!Auth::attempt($data)){
                return ResponderFacade::
                    setExceptionMessage('The information entered is incorrect.')
                    ->respondError();
            }
            $user = User::where($type, $request->username)->first();
            $user->token = $user->createToken("API TOKEN")->plainTextToken;
            return ResponderFacade::setData($user)
                ->respond();
        } catch (Exception $exception) {
            return ResponderFacade::
                setExceptionMessage($exception->getMessage())
                ->respondError();
        }
    }
}
