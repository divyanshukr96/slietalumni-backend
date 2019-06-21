<?php

namespace App\Http\Controllers;

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
                    $this->getUsername() => 'Invalid username or password entered !!',
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
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
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
            'message' => 'Successfully logged out'
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

}
