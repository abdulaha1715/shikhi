<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user_id'          => $this->id,
            'user_name'        => $this->name,
            'user_thumb'       => getAssetsUrl($this->thumbnail, 'uploads'),
            'user_email'       => $this->email,
            'user_mobile'      => $this->mobile,
            'user_location'    => $this->location,
            'user_join_date'   => $this->created_at->format('d M, Y'),
            'user_last_update' => $this->updated_at->format('d M, Y'),
        ];
    }
}
