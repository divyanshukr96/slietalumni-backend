<?php

namespace App\Http\Controllers\API;

use App\Donation;
use App\Http\Requests\DonationConfirmationValidation;
use App\Http\Requests\DonationStoreValidate;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DonationStoreValidate $request
     * @return Response
     */
    public function store(DonationStoreValidate $request)
    {
        if ($request->has('member')) {
            $username = $request->get('member');
            $user = User::whereUsername($username)->first();
            if (!$user) abort('401', 'Invalid user credentials');
            $professional = $user->professional->first();
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
            $donation = $user->donations()->save(new Donation($data));

            return \response($donation);
        }
        $donation = Donation::create($request->validated());

        return \response($donation);
    }

    /**
     * Display the specified resource.
     *
     * @param Donation $donation
     * @return Donation
     */
    public function show(Donation $donation)
    {
        return $donation->verifyBy;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DonationConfirmationValidation $request
     * @param Donation $donation
     * @return Donation
     */
    public function update(DonationConfirmationValidation $request, Donation $donation)
    {
        $donation->verified_by = auth()->user()->getAuthIdentifier();
        $donation->verified_at = Carbon::now();
        $donation->verified = true;
        $donation->save();
        return $donation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
