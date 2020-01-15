<?php

namespace App\Http\Controllers\API;

use App\Donation;
use App\Http\Requests\DonationConfirmationValidation;
use App\Http\Requests\DonationStoreValidate;
use App\Http\Resources\Donation as DonationResource;
use App\Traits\AuthUser;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use League\OAuth2\Server\ResourceServer;

/**
 * @property ResourceServer server
 */
class DonationController extends Controller
{
    use AuthUser;

    /**
     * DonationController constructor.
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
        return DonationResource::collection(Donation::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DonationStoreValidate $request
     * @return JsonResponse|Response
     */
    public function store(DonationStoreValidate $request)  // public can access this to post a donation
    {
        if ($request->has('member')) {
            $authUser = $this->getUser($request);
            $username = $request->get('member');
            $user = User::whereUsername($username)->first();
            if (!$user || !$authUser || ($user->id != $authUser->id)) return response()->json([
                'status' => "invalid data",
                'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'time' => Carbon::now()->toDateTimeString(),
                'errors' => [
                    'member' => 'User is not authenticated currently!'
                ]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);;

            $professional = $user->professional;
            $validateDta = $request->validated();
            $data = [
                'member' => $validateDta['member'],
                'amount' => $validateDta['amount'],
                'receipt' => $validateDta['receipt'],
                'category' => $validateDta['category']
            ];
            if ($user->mobile) $data['mobile'] = $request->get('mobile');
            if (!$professional) {
                $data['organisation'] = $request->get('organisation');
                $data['designation'] = $request->get('designation');
            }
            $donation = $user->donations()->create($data);

            return response()->json([
                'time' => Carbon::now()->toDateTimeString(),
                'data' => $donation
            ], 201);
        }
        $donation = Donation::create($request->validated());

        return response()->json([
            'time' => Carbon::now()->toDateTimeString(),
            'data' => $donation
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Donation $donation
     * @return Donation|DonationResource
     */
    public function show(Donation $donation)
    {
        return new DonationResource($donation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DonationConfirmationValidation $request
     * @param Donation $donation
     * @return Donation|DonationResource
     */
    public function update(DonationConfirmationValidation $request, Donation $donation)
    {
        if ($donation->verified) return new DonationResource($donation);
        $donation->fill($request->validated());
        $donation->verified_by = auth()->user()->getAuthIdentifier();
        $donation->verified_at = Carbon::now();
        $donation->verified = true;
        $donation->save();
        return new DonationResource($donation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Donation $donation
     * @return DonationResource
     * @throws Exception
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();
        return new DonationResource($donation);
    }
}
