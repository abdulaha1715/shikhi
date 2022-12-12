<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use App\Models\Review;

class CourseController extends Controller
{
    /**
     * Index Method
     */
    public function index() {
        try {
            $courses = Course::where('status', 'active')->latest()->get();

            // Response
            return [
                'error' => false,
                'data'  => collect($courses)->map(function($course) {
                    return new CourseResource($course);
                }),
            ];

        } catch (\Throwable $th) {
            // Response
            return [
                'error'   => true,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Single Course Method
     */
    public function singleCourse( $slug ) {
        try {
            $course = Course::where('slug', $slug)->where('status', 'active')->get()->first();

            return [
                'error' => false,
                'data'  => new CourseResource($course),
            ];

        } catch (\Throwable $th) {
            return [
                'error'   => true,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Course Enroll Method
     */
    public function CourseEnroll( $slug ) {
        try {
            if ( ! Auth::user() ) {
                return [
                    'error'   => true,
                    'message' => "You need to login!",
                ];
            }

            $course = Course::where('slug', $slug)->where('status', 'active')->get()->first();

            $user = Auth::user();
            /** @var User $user */

            $checkenroll = $user->courses->find($course->id);

            // if ( $enrollvar['attached'] != [] ) {
            //     return [
            //         'error'   => false,
            //         'message' => "Course Enrolled Successfully!",
            //     ];
            // }

            if ( $checkenroll ) {
                return [
                    'error'   => true,
                    'message' => "You already enroll this course!",
                ];
            } else {
                $user->courses()->sync([$course->id]);
                $user->wishlist()->detach([$course->id]);
                return [
                    'error'   => false,
                    'message' => "Course Enrolled Successfully!",
                ];
            }





        } catch (\Throwable $th) {
            return [
                'error'   => true,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Course Wishlist Method
     */
    public function Coursewishlist( $slug ) {
        try {
            if ( ! Auth::user() ) {
                return [
                    'error'   => true,
                    'message' => "You need to login!",
                ];
            }

            $course = Course::where('slug', $slug)->where('status', 'active')->get()->first();

            $user = Auth::user();
            /** @var User $user */


            $checkenroll = $user->courses->find($course->id);

            $checkwishlist = $user->wishlist->find($course->id);

            // if ( $enrollvar['attached'] != [] ) {
            //     return [
            //         'error'   => false,
            //         'message' => "Course Enrolled Successfully!",
            //     ];
            // }

            if ( $checkenroll ) {
                return [
                    'error'   => true,
                    'message' => "You already Enrolled this Course!",
                ];
            }

            if ( $checkwishlist ) {
                return [
                    'error'   => true,
                    'message' => "You already added to wishlist!",
                ];
            } else {
                $enrollvar = $user->wishlist()->sync([$course->id]);

                return [
                    'error'   => false,
                    'message' => "Course added to Wishlist!",
                ];
            }





        } catch (\Throwable $th) {
            return [
                'error'   => true,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Course Review Method
     */
    public function CourseReview( Request $request,$slug ) {
        $request->validate([
            'star'    => ['required', 'numeric', "max:5"],
            'content' => ['required', 'string'],
        ]);

        try {
            if ( ! Auth::user() ) {
                return [
                    'error'   => true,
                    'message' => "You need to login!",
                ];
            }

            $course = Course::where('slug', $slug)->where('status', 'active')->get()->first();

            $user = Auth::user();
            /** @var User $user */


            $checkenroll = $user->courses->find($course->id);

            if ( ! $checkenroll ) {
                return [
                    'error'   => true,
                    'message' => "Your need to enroll first!",
                ];
            }

            $review = Review::where('course_id', $course->id)->where('student_id', $user->id)->get()->first();

            Review::updateOrCreate(['id' => $review->id], [
                'star'       => $request->star,
                'content'    => $request->content,
                'student_id' => $user->id,
                'course_id'  => $course->id
            ]);

            return [
                'error'   => false,
                'message' => "Your valuable review posted Successfully!",
            ];

        } catch (\Throwable $th) {
            return [
                'error'   => true,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Course Lesson Method
     */
    public function CourseLesson( $course, $lesson ) {

        try {
            if ( ! Auth::user() ) {
                return [
                    'error'   => true,
                    'message' => "You need to login!",
                ];
            }

            $course = Course::where('slug', $course)->where('status', 'active')->get()->first();

            $user = Auth::user();
            /** @var User $user */

            $checkenroll = $user->courses->find($course->id);

            if ( ! $checkenroll ) {
                return [
                    'error'   => true,
                    'message' => "Your need to enroll first!",
                ];
            }

            $lesson = Lesson::where('slug', $lesson)->where('status', 'public')->get()->first();

            return [
                'error' => false,
                'data'  => new LessonResource($lesson)
            ];

        } catch (\Throwable $th) {
            return [
                'error'   => true,
                'message' => $th->getMessage(),
            ];
        }
    }
}
