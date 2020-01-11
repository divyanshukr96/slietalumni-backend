<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed meet_id
 * @property mixed name
 * @property mixed email
 * @property mixed mobile
 * @property mixed programme
 * @property mixed branch
 * @property mixed batch
 * @property mixed passing
 * @property mixed organisation
 * @property mixed designation
 * @property mixed family
 * @property mixed accommodation
 * @property mixed requirements
 * @property mixed year
 * @property mixed fees
 * @property mixed verified
 * @property mixed verified_at
 * @property mixed verifyBy
 * @property mixed created_at
 * @property mixed alumni
 */
class AlumniMeet extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {

        if ($this->alumni) {
            $academic = $this->alumni->academics->first();
            $professional = $this->alumni->professionals->first();
            $data = [
                $this->mergeWhen($academic, [
                    "programme" => $academic['programme'],
                    "branch" => $academic['branch'],
                    "batch" => $academic['batch'],
                    "passing" => $academic['passing'],
                ]),
                $this->mergeWhen($professional, [
                    "organisation" => $professional['organisation'],
                    "designation" => $professional['designation'],
                ]),
            ];
        } else {
            $data = [
                "programme" => $this->programme,
                "branch" => $this->branch,
                "batch" => $this->batch,
                "passing" => $this->passing,
                "organisation" => $this->organisation,
                "designation" => $this->designation,
            ];
        };

        return array_merge(
            [
                "id" => $this->id,
                "meet_id" => $this->meet_id,
                "name" => $this->name,
                "email" => $this->email,
                "mobile" => $this->mobile,
            ],
            $data,
            [
                "family" => $this->family,
                "accommodation" => $this->accommodation,
                "requirements" => $this->requirements,
                "year" => $this->year,
                "fees" => $this->fees,

                'verified' => $this->verified,
                'verified_at' => $this->when($this->verified and $this->verified_at, function () {
                    return Carbon::parse($this->verified_at)->format('d M Y H:i');
                }),
                'verified_by' => $this->when($this->verified and $this->verifyBy, function () {
                    return $this->verifyBy->name;
                }),
                "created_at" => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
            ]
        );
    }
}
