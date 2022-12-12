<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'review_star'    => $this->star,
            'review_content' => $this->content,
            'review_by'      => new UserResource( $this->student ),
            'last_update'    => $this->updated_at->format('d F, Y'),
        ];
    }
}
