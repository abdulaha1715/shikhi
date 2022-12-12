<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'course_id'          => $this->id,
            'course_name'        => $this->name,
            'course_slug'        => $this->slug,
            'course_description' => $this->description,
            'course_thumb'       => $this->thumbnail,
            'course_side_note'   => $this->side_note,
            'course_level'       => $this->level,
            'course_category'    => $this->category->name,
            'course_teacher'     => new UserResource( $this->teacher ),
            'course_lessons'     => collect($this->lessons)->map(function($lesson) {
                return new LessonResource( $lesson );
            }),
            'course_reviews'     => collect($this->reviews)->map(function($review) {
                return new ReviewResource( $review );
            }),
            'last_update'        => $this->updated_at->format('d F, Y'),
        ];
    }
}
