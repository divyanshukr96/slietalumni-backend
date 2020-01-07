<?php

namespace App\Http\Controllers\API;

use App\AlumniMeet;
use App\Http\Controllers\Controller;
use App\Http\Requests\MeetStoreValidate;
use App\Http\Resources\AlumniMeet as AlumniMeetResource;
use App\Traits\AuthUser;
use App\User;
use Carbon\Carbon;
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

            $meet = AlumniMeet::create($validateDta);
            $meet->alumni()->associate($user)->save();

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
     * @param Request $request
     * @param AlumniMeet $alumniMeet
     * @return Response
     */
    public function update(Request $request, AlumniMeet $alumniMeet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AlumniMeet $alumniMeet
     * @return Response
     */
    public function destroy(AlumniMeet $alumniMeet)
    {
        //
    }
}
