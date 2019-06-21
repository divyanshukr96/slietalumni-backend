<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed guard_name
 * @property mixed name
 * @property mixed display_name
 * @property mixed description
 * @property mixed created_at
 * @property mixed roles
 * @property mixed id
 */
class Permission extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "name" => $this->name,
            "guard_name" => $this->guard_name,
            "display_name" => $this->display_name,
            "description" => $this->description,
            "created_at" => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
            "roles" => $this->roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    "name" => $role->name,
                    "guard_name" => $role->guard_name,
                    "display_name" => $role->display_name,
                    "description" => $role->description,
                    "created_at" => Carbon::parse($role->created_at)->format('d-m-Y H:i'),
                    "pivot" => $role->pivot
                ];
            }),
        ];
    }
}
