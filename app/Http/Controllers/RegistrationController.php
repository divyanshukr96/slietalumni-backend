<?php

namespace App\Http\Controllers;

use App\DataCollection;
use App\Http\Requests\RegistrationPaymentValidation;
use App\Image;
use DB;
use Str;
use Hash;
use App\User;
use App\Academic;
use App\Registration;
use App\ProfessionalDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Resources\RegisteredAlumni;
use App\Http\Requests\SetUsernameValidate;
use App\Http\Resources\AlumniRegisterResource;
use App\Http\Requests\AlumniRegistrationStoreValidation;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return RegisteredAlumni::collection(Registration::latest()->whereVerified(false)->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param AlumniRegistrationStoreValidation $request
     * @return AlumniRegisterResource
     */
    public function store(AlumniRegistrationStoreValidation $request)
    {
        return new AlumniRegisterResource(Registration::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param Registration $alumni
     * @return RegisteredAlumni
     */
    public function show(Registration $alumni)
    {
        return new RegisteredAlumni($alumni);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Registration $alumniRegistration
     * @return Response
     */
    public function edit(Registration $alumniRegistration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RegistrationPaymentValidation $request
     * @param Registration $alumni
     * @return RegisteredAlumni
     */
    public function update(RegistrationPaymentValidation $request, Registration $alumni)
    {
        if ($alumni->verified) return response()->json([
            'alreadyVerified' => true,
            'data' => $alumni
        ]);
        $token = Str::random(60);
        $status = DB::table('username_tokens')->insert([
            'email' => $alumni->email,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $payment = $alumni->payment ? true : $alumni->payment()->create($request->validated());
        if ($status && $payment) {
            $alumni->verified = true;
            $alumni->verified_by = auth()->user()->getAuthIdentifier();
        }
        $alumni->save();

        //send a mail to alumni with $tokenAP

        return new RegisteredAlumni($alumni);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SetUsernameValidate $request
     * @return UserResource
     */
    public function setUsername(SetUsernameValidate $request)
    {
        $validateData = $request->validated();
        $context = DB::table('username_tokens')->where('token', $validateData['token'])->get()->first();
        if (!$context) {
            return response()->json(['errors' => []], 404);
        }
        if ($context->email !== $request->get('email')) {
            return response()->json([
                'status' => "Invalid data",
                'code' => JsonResponse::HTTP_NOT_FOUND,
                'message' => 'Invalid credential given . . .',
                'errors' => [
                    'email' => "The given email id invalid.",
                ]
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $alumni = Registration::where('email', $context->email)->get()->first();

        if (!$alumni) {
            return response()->json([
                'status' => "Invalid data",
                'code' => JsonResponse::HTTP_NOT_FOUND,
                'message' => 'Invalid credential given . . .',
                'errors' => [
                    'email' => "The given email id invalid.",
                ]
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = [
            'name' => $alumni->name,
            'email' => $alumni->email,
            'mobile' => $alumni->mobile,
            'username' => $validateData['username'],
            'password' => $validateData['password'],
            'image_id' => $alumni->image->id,
            'alumni' => true
        ];
        $user = new User($data);
//        $user->save();
//        $user->educations()->save(new Academic([
//            "programme" => $alumni->programme,
//            "branch" => $alumni->branch,
//            "batch" => $alumni->batch,
//            "passing" => $alumni->passing,
//        ]));
//        $user->professional()->save(new ProfessionalDetails([
//            "organisation" => $alumni->organisation,
//            "designation" => $alumni->designation,
//        ]));
//
//        // send welcome email to user
//
//        $alumni->delete();
//        DB::table('username_tokens')->where('email', $context->email)->delete();

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Registration $alumniRegistration
     * @return Response
     */
    public function destroy(Registration $alumniRegistration)
    {
        //
    }


    public function related(Registration $alumni)
    {
        $data = DataCollection::where('email', $alumni->email)->orWhere('mobile', $alumni->mobile)->get();

        return $data;
    }

}
