<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

/**
 * @property mixed name
 * @property mixed guard_name
 * @property mixed display_name
 * @property mixed description
 * @property mixed created_at
 * @property mixed permissions
 * @property mixed id
 */
class Role extends JsonResource
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
            "permissions" => $this->permissions->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    "name" => $permission->name,
                    "guard_name" => $permission->guard_name,
                    "display_name" => $permission->display_name,
                    "description" => $permission->description,
                    "created_at" => Carbon::parse($permission->created_at)->format('d-m-Y H:i'),
                ];
            })
        ];
    }
}
