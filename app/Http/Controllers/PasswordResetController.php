<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequestValidation;
use App\Http\Requests\PasswordResetValidation;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Password;
use Str;

class PasswordResetController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param PasswordResetRequestValidation $request
     * @return JsonResponse|RedirectResponse
     */
    public function forgot(PasswordResetRequestValidation $request)
    {
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendSuccessResponse($request, $response)
            : $this->sendFailedResponse($request, $response);

    }


    /**
     * Reset the given user's password.
     *
     * @param PasswordResetValidation $request
     * @return RedirectResponse|JsonResponse
     */
    public function reset(PasswordResetValidation $request)
    {
        $response = $this->broker()->reset(
            $this->resetCredentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        return $response == Password::PASSWORD_RESET
            ? $this->sendSuccessResponse($request, $response)
            : $this->sendFailedResponse($request, $response);
    }


    /**
     * Get the response for a successful password reset link.
     *
     * @param Request $request
     * @param string $response
     * @return RedirectResponse|JsonResponse
     */
    protected function sendSuccessResponse(Request $request, $response)
    {
        return response()->json([
            'status' => 'success',
            'code' => 200,
            "time" => Carbon::now()->toDateTimeString(),
            "message" => trans($response)
        ], 200);
    }


    /**
     * Get the response for a failed password reset link.
     *
     * @param Request $request
     * @param string $response
     * @return RedirectResponse|JsonResponse
     */
    protected function sendFailedResponse(Request $request, $response)
    {
        return response()->json([
            'status' => 'invalid data',
            'code' => 422,
            "time" => Carbon::now()->toDateTimeString(),
            "errors" => [
                "email" => trans($response)
            ]
        ], 422);
    }


    /**
     * Get the password reset credentials from the request.
     *
     * @param Request $request
     * @return array
     */
    private function resetCredentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }


    /**
     * Get the needed authentication credentials from the request.
     *
     * @param Request $request
     * @return array
     */
    private function credentials(Request $request)
    {
        return $request->only('email');
    }


    /**
     * Reset the given user's password.
     *
     * @param CanResetPassword $user
     * @param string $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

    }


    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

}
