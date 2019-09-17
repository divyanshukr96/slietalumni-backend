<?php

namespace App\Http\Controllers;

use App\Http\Resources\Profile;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequestValidate;

class AuthController extends Controller
{
    protected $username;

    public function __construct()
    {
        $this->middleware('auth:api')->except('login');
        $this->username = $this->findUsername();
    }

    /**
     * Login user and create token
     * @param LoginRequestValidate $request
     * @return JsonResponse
     */
    public function login(LoginRequestValidate $request)
    {
        $credentials = request([$this->getUsername(), 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized',
                'errors' => [
                    'username' => "Invalid $this->username or password entered !!",
                    'email' => "Invalid $this->username or password entered !!",
                    'password' => ''
                ],
            ], 422);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'time' => Carbon::now()->toDateTimeString(),
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->map(function ($data) {
                return $data->name;
            }),
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return JsonResponse [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'time' => Carbon::now()->toDateTimeString(),
            'message' => 'User Successfully logged out . . .'
        ]);
    }

    public function findUsername()
    {
        $login = request()->input('username') ?: request()->input('email');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return JsonResponse
     */
    public function check()
    {
        $user = auth()->user();
        return response()->json([
            'time' => Carbon::now()->toDateTimeString(),
            'data' => [
                'name' => ucwords($user->name),
                'email' => $user->email,
                'username' => $user->username,
                'image' => $user->image,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->map(function ($data) {
                    return $data->name;
                }),
                'professional' => $user->professionals()->latest(),
            ]
        ]);
    }

    public function profile()
    {
        return new Profile(auth()->user());
    }

}
