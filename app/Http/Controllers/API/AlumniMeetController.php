<?php

namespace App\Http\Controllers\API;

use App\AlumniMeet;
use App\Http\Controllers\Controller;
use App\Http\Requests\MeetConfirmValidate;
use App\Http\Requests\MeetStoreValidate;
use App\Http\Resources\AlumniMeet as AlumniMeetResource;
use App\Traits\AuthUser;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use League\OAuth2\Server\ResourceServer;

class AlumniMeetController extends Controller
{
    use AuthUser;


    /**
     * AlumniMeetController constructor.
     * @param ResourceServer $server
     */
    public function __construct(ResourceServer $server)
    {
        $this->server = $server;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        $alumniMeet = AlumniMeet::latest();

        if (request()->year) $alumniMeet->where('year', request()->year);

        return AlumniMeetResource::collection($alumniMeet->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MeetStoreValidate $request
     * @return JsonResponse|Response
     */
    public function store(MeetStoreValidate $request)
    {
        if ($request->has('member')) {

            $authUser = $this->getUser($request);

            $email = $request->get('member');
            $user = User::whereEmail($email)->first();
            if (!$user || !$authUser || ($user->id != $authUser->id)) return response()->json([
                'status' => "invalid data",
                'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'time' => Carbon::now()->toDateTimeString(),
                'errors' => [
                    'member' => 'User is not authenticated currently!'
                ]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

            $validateDta = $request->validated();
            $validateDta['name'] = $user->name;
            $validateDta['email'] = $user->email;
            $validateDta['mobile'] = $user->mobile;

            $meet = $user->alumniMeet()->create($validateDta);

            return response()->json([
                'time' => Carbon::now()->toDateTimeString(),
                'data' => $meet
            ], 201);
        }

        $meet = AlumniMeet::create($request->validated());

        return response()->json([
            'time' => Carbon::now()->toDateTimeString(),
            'data' => $meet
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param AlumniMeet $alumniMeet
     * @return Response
     */
    public function show(AlumniMeet $alumniMeet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MeetStoreValidate $request
     * @param AlumniMeet $alumniMeet
     * @return AlumniMeetResource
     */
    public function update(MeetStoreValidate $request, AlumniMeet $alumniMeet)
    {
        $alumniMeet->fill($request->validated());
        $alumniMeet->fees = AlumniMeet::fees($alumniMeet);
        $alumniMeet->save();
        return new AlumniMeetResource($alumniMeet);
    }

    /**
     * confirm the registration of alumni meet.
     *
     * @param MeetConfirmValidate $request
     * @param AlumniMeet $alumniMeet
     * @return AlumniMeetResource
     */
    public function confirm(MeetConfirmValidate $request, AlumniMeet $alumniMeet)
    {
        if ($alumniMeet->verified) return new AlumniMeetResource($alumniMeet);

        $payment = $alumniMeet->payment ? true : $alumniMeet->payment()->create($request->validated());

        $meet_id = $alumniMeet->year . "/" . (AlumniMeet::whereNotNull("meet_id")->count() + 101);

        if ($payment) {
            $alumniMeet->meet_id = $meet_id;
            $alumniMeet->verified = true;
            $alumniMeet->verified_at = Carbon::now();
            $alumniMeet->verified_by = auth()->user()->getAuthIdentifier();
        }
        $alumniMeet->save();

//        $alumniMeet->notify(new RegistrationConfirmation($alumni, $token));

        return new AlumniMeetResource($alumniMeet);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AlumniMeet $alumniMeet
     * @return AlumniMeetResource
     * @throws Exception
     */
    public function destroy(AlumniMeet $alumniMeet)
    {
        $alumniMeet->delete();
        return new AlumniMeetResource($alumniMeet);
    }
}
