<?php

namespace App\Http\Resources;

use App\Models\LessonUser;
use Illuminate\Support\Facades\Auth;
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
        $course_array = [
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
                return [
                    'lesson_id'          => $lesson->id,
                    'lesson_name'        => $lesson->name,
                    'lesson_slug'        => $lesson->slug,
                    'visiblity'          => $lesson->status,
                    'last_update'        => $lesson->updated_at->format('d F, Y'),
                ];
            }),
            'course_reviews'     => collect($this->reviews)->map(function($review) {
                return new ReviewResource( $review );
            }),
            'last_update'        => $this->updated_at->format('d F, Y'),

        ];

        if ( auth()->user() ) {
            $user = Auth::user();
            /** @var User $user */

            // Check course enroll
            $checkenroll = $this->students->find( $user->id );

            // Additional data base on course enroll or not
            if ( $checkenroll ) {
                $total_lesson = count($this->lessons);
                $lesson       = count(LessonUser::where('course_id', $this->id)->where('student_id', $user->id)->get());
                $course_array['progress'] = $lesson > 0 ? (String)  number_format((float)($lesson/$total_lesson * 100), 2, '.', ''). "%" : "0%";
                $course_array['status'] = ucfirst($this->pivot->status);
            }

        }

        return $course_array;
    }
}
