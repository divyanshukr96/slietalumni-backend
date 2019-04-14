<?php

namespace App\Http\Controllers;

use App\AlumniRegistration;
use App\Http\Requests\AlumniRegistrationStoreValidation;
use App\Http\Requests\SetUsernameValidate;
use App\Http\Resources\AlumniRegisterResource;
use App\Http\Resources\RegisteredAlumni;
use App\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Str;

class AlumniRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return RegisteredAlumni::collection(AlumniRegistration::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param AlumniRegistrationStoreValidation $request
     * @return AlumniRegisterResource
     */
    public function store(AlumniRegistrationStoreValidation $request)
    {
        return new AlumniRegisterResource(AlumniRegistration::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param AlumniRegistration $alumni
     * @return RegisteredAlumni
     */
    public function show(AlumniRegistration $alumni)
    {
        return new RegisteredAlumni($alumni);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AlumniRegistration $alumniRegistration
     * @return Response
     */
    public function edit(AlumniRegistration $alumniRegistration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AlumniRegistration $alumni
     * @return RegisteredAlumni
     */
    public function update(Request $request, AlumniRegistration $alumni)
    {
        $token = Str::random(60);
        $status = DB::table('username_tokens')->insert([
            'email' => $alumni->email,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        if ($status) $alumni->verified = true;
        $alumni->save();

        //send a mail to alumni with $token

        return new RegisteredAlumni($alumni);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SetUsernameValidate $request
     * @return RegisteredAlumni
     */
    public function setUsername(SetUsernameValidate $request)
    {
        $context = DB::table('username_tokens')->where('token', $request->get('token'))->get()->first();
        if (!$context) {
            return response()->json('error', 400);
        }
        if ($context->email !== $request->get('email')) {
            return response()->json('not match mail', 400);
        }

        $alumni = AlumniRegistration::where('email', $context->email)->get()->first();

        $data = [
            'name' => $alumni->name,
            'email' => $alumni->email,
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'image_id' => $alumni->image->id,
            'mobile' => $alumni->mobile
        ];
        $user = User::create($data);

//        $user->educationa()->save(new Education::create([]))
//        $user->workinf()->save(new Working::create([]))

        $alumni->delete();
        DB::table('username_tokens')->where('token', $request->get('token'))->delete();

        return response()->json(['alumni' => $alumni, 'user' => $user]);
//        return ;


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AlumniRegistration $alumniRegistration
     * @return Response
     */
    public function destroy(AlumniRegistration $alumniRegistration)
    {
        //
    }
}
