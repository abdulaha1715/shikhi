<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'lesson_id'          => $this->id,
            'lesson_name'        => $this->name,
            'lesson_slug'        => $this->slug,
            'lesson_description' => $this->content,
            'last_update'        => $this->updated_at->format('d F, Y'),
        ];
    }
}
