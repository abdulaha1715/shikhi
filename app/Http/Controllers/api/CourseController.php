<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Review;
use App\Models\LessonUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonResource;

class CourseController extends Controller
{
    /**
     * Index Method
     */
    public function index()
    {
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
    public function singleCourse( $slug )
    {
        try {
            $course = Course::where('slug', $slug)->where('status', 'active')->get()->first();

            // Response
            return [
                'error' => false,
                'data'  => new CourseResource($course),
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
     * Course Enroll Method
     */
    public function CourseEnroll( Request $request )
    {
        $request->validate([
            'course_id' => ['required', 'integer']
        ]);

        try {
            if ( ! Auth::user() ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You need to login!",
                ];
            }

            $course = Course::find($request->course_id);

            $user = Auth::user();
            /** @var User $user */

            $checkenroll = $course->students->find( $user->id );

            // if ( $enrollvar['attached'] != [] ) {
            //     return [
            //         'error'   => false,
            //         'message' => "Course Enrolled Successfully!",
            //     ];
            // }

            if ( $checkenroll ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You already enroll this course!",
                ];
            } else {
                $course->students()->sync([$user->id]);
                $course->wishlist()->detach([$user->id]);

                // Response
                return [
                    'error'   => false,
                    'message' => "Course Enrolled Successfully!",
                ];
            }

        } catch (\Throwable $th) {
            // Response
            return [
                'error'   => true,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Course Wishlist Method
     */
    public function Coursewishlist( Request $request )
    {
        $request->validate([
            'course_id' => ['required', 'integer']
        ]);

        try {
            if ( ! Auth::user() ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You need to login!",
                ];
            }

            $course = Course::findOrFail($request->course_id);

            $user = Auth::user();
            /** @var User $user */


            $checkenroll   = $course->students->find( $user->id );
            $checkwishlist = $user->wishlist->find($course->id);

            // if ( $enrollvar['attached'] != [] ) {
            //     // Response
            //      return [
            //         'error'   => false,
            //         'message' => "Course Enrolled Successfully!",
            //     ];
            // }

            if ( $checkenroll ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You already Enrolled this Course!",
                ];
            }

            if ( $checkwishlist ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You already added to wishlist!",
                ];
            } else {
                $course->wishlist()->sync([$user->id]);

                // Response
                return [
                    'error'   => false,
                    'message' => "Course added to Wishlist!",
                ];
            }

        } catch (\Throwable $th) {
            // Response
            return [
                'error'   => true,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Course Review Method
     */
    public function CourseReview( Request $request )
    {
        $request->validate([
            'course_id' => ['required', 'integer'],
            'star'      => ['required', 'numeric', "max:5"],
            'content'   => ['required', 'string'],
        ]);

        try {
            if ( ! Auth::user() ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You need to login!",
                ];
            }

            $course = Course::find($request->course_id);

            $user = Auth::user();
            /** @var User $user */

            $checkenroll = $course->students->find( $user->id );

            if ( ! $checkenroll ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "Your need to enroll first!",
                ];
            }

            $review = Review::where('course_id', $course->id)->where('student_id', $user->id)->get()->first();

            if ( $review ) {
                $review->update([
                    'star'       => $request->star,
                    'content'    => $request->content,
                    'student_id' => $user->id,
                    'course_id'  => $course->id
                ]);
            } else {
                Review::create([
                    'star'       => $request->star,
                    'content'    => $request->content,
                    'student_id' => $user->id,
                    'course_id'  => $course->id
                ]);
            }

            // Response
            return [
                'error'   => false,
                'message' => "Your valuable review posted Successfully!",
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
     * Course Lesson Method
     */
    public function CourseLesson( $course, $lesson )
    {

        try {


            $course = Course::where('slug', $course)->where('status', 'active')->get()->first();

            if ( auth()->user() ) {
                $user = Auth::user();
                /** @var User $user */

                $lesson      = Lesson::where('slug', $lesson)->get()->first();
                $checkenroll = $course->students->find( $user->id );

                if ( ! $checkenroll ) {
                    // Response
                return [
                        'error'   => true,
                        'message' => "Your need to enroll first!",
                    ];
                }
            } else {
                $lesson = Lesson::where('slug', $lesson)->where('status', 'public')->get()->first();
            }

            // Response
            return [
                'error' => false,
                'data'  => $lesson ? new LessonResource($lesson) : "Your need to enroll first!",
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
     * markCourseAsComplete method.
     *
     * @return \Illuminate\Http\Response
     */
    public function markCourseAsComplete( Request $request )
    {
        $request->validate([
            'course_id' => ['required', 'integer'],
        ]);

        try {

            $user = Auth::user();
            /** @var User $user */

            $course      = Course::find($request->course_id);
            $checkenroll = $course->students->find( $user->id );

            if ( ! $checkenroll ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You are unauthorized!",
                ];
            }

            if ( ! $course ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "Course not found!",
                ];
            }

            $course->students()->updateExistingPivot( $user->id, array('status' => 'complete') );

            // Response
            return [
                'error'   => false,
                'message' => "Course marked as complete!",
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
     * markLessonAsComplete method.
     *
     * @return \Illuminate\Http\Response
     */
    public function markLessonAsComplete( Request $request )
    {
        $request->validate([
            'course_id' => ['required', 'integer'],
            'lesson_id' => ['required', 'integer'],
        ]);

        try {

            $user = Auth::user();
            /** @var User $user */

            $course      = Course::find($request->course_id);
            $checkenroll = $course->students->find( $user->id );

            if ( ! $checkenroll ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You are unauthorized!",
                ];
            }

            $request_lesson_id = $request->lesson_id;
            $find_lesson_id    = $course->lessons()->where('id', $request_lesson_id)->get()->first();

            if ( ! $find_lesson_id ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "Lesson not found!",
                ];
            }

            $lesson_user = LessonUser::where('course_id', $request->course_id)->where('lesson_id', $request->lesson_id)->where('student_id', $user->id)->get()->first();

            if ( $lesson_user ) {
                $lesson_user->delete();
                // Response
                return [
                    'error'   => false,
                    'message' => "Lesson marked as incomplete!",
                ];
            }

            LessonUser::create([
                'course_id'  => $request->course_id,
                'lesson_id'  => $request->lesson_id,
                'student_id' => $user->id,
            ]);

            // Response
            return [
                'error'   => false,
                'message' => "Lesson marked as complete!",
            ];

        } catch (\Throwable $th) {
            // Response
            return [
                'error'   => true,
                'message' => $th->getMessage(),
            ];
        }
    }
}
