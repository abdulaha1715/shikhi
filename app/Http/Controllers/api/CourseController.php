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
            // All Courses
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
            // Find Course
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
        // Validation
        $request->validate([
            'course_id' => ['required', 'integer']
        ]);

        try {
            // Check user logged in
            if ( ! Auth::user() ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You need to login!",
                ];
            }

            // Find Course
            $course = Course::find($request->course_id);

            $user = Auth::user();
            /** @var User $user */

            // Check Enroll Course
            $checkenroll = $course->students->find( $user->id );

            // if ( $enrollvar['attached'] != [] ) {
            //     return [
            //         'error'   => false,
            //         'message' => "Course Enrolled Successfully!",
            //     ];
            // }

            // Course enroll conditionally
            if ( $checkenroll ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You already enroll this course!",
                ];
            } else {
                // Enroll Course
                $course->students()->sync([$user->id]);
                // Remove Course from Wishlist
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
        // Validation
        $request->validate([
            'course_id' => ['required', 'integer']
        ]);

        try {
            // Check user logged in
            if ( ! Auth::user() ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You need to login!",
                ];
            }

            // Find Course
            $course = Course::findOrFail($request->course_id);

            $user = Auth::user();
            /** @var User $user */

            // Check Enroll Course
            $checkenroll   = $course->students->find( $user->id );
            // Check Course Wishlist
            $checkwishlist = $user->wishlist->find($course->id);

            // if ( $enrollvar['attached'] != [] ) {
            //     // Response
            //      return [
            //         'error'   => false,
            //         'message' => "Course Enrolled Successfully!",
            //     ];
            // }

            // Check Couses enroll or not
            if ( $checkenroll ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You already Enrolled this Course!",
                ];
            }

            // Course added wishlist conditionally
            if ( $checkwishlist ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You already added to wishlist!",
                ];
            } else {
                // Course add in wishlist
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
        // Validation
        $request->validate([
            'course_id' => ['required', 'integer'],
            'star'      => ['required', 'numeric', "max:5"],
            'content'   => ['required', 'string'],
        ]);

        try {
            // Check user logged in
            if ( ! Auth::user() ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You need to login!",
                ];
            }

            // Find Course
            $course = Course::find($request->course_id);

            $user = Auth::user();
            /** @var User $user */

            // Check Enroll Course
            $checkenroll = $course->students->find( $user->id );

            // Check Couses enroll or not
            if ( ! $checkenroll ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "Your need to enroll first!",
                ];
            }

            // Check and get Review from database
            $review = Review::where('course_id', $course->id)->where('student_id', $user->id)->get()->first();

            if ( $review ) {
                // Update review
                $review->update([
                    'star'       => $request->star,
                    'content'    => $request->content,
                    'student_id' => $user->id,
                    'course_id'  => $course->id
                ]);
            } else {
                // Create Review
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
            // Find Course
            $course = Course::where('slug', $course)->where('status', 'active')->get()->first();
            // Find Course lesson
            $lesson = Lesson::where('slug', $lesson)->where('course_id', $course->id);

            // Check Course lesson
            if ( ! $lesson->get()->first() ) {
                // Response
                 return [
                    'error'   => true,
                    'message' => "Lesson not found!",
                ];
            }

            // Get Lesson base on User
            if ( auth()->user() ) {
                $user = Auth::user();
                /** @var User $user */

                // Get Course Lesson
                $checkenroll = $course->students->find( $user->id );

                // Check Course Enroll or not
                if ( ! $checkenroll ) {
                    // Response
                    return [
                        'error'   => true,
                        'message' => "Your need to enroll first!",
                    ];
                }
            } else {
                // All public lesson
                $lesson = $lesson->where('status', 'public');
            }

            // Lesson Get first
            $lesson = $lesson->get()->first();

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
        // Validation
        $request->validate([
            'course_id' => ['required', 'integer'],
        ]);

        try {
            $user = Auth::user();
            /** @var User $user */


            // Find Course
            $course      = Course::find($request->course_id);
            // Check Enroll Course
            $checkenroll = $course->students->find( $user->id );

            // Check Course Enroll or not
            if ( ! $checkenroll ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You are unauthorized!",
                ];
            }

            // Check Course
            if ( ! $course ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "Course not found!",
                ];
            }

            // Update Course status in pivot table
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
        // Validation
        $request->validate([
            'course_id' => ['required', 'integer'],
            'lesson_id' => ['required', 'integer'],
        ]);

        try {
            $user = Auth::user();
            /** @var User $user */

            // Find Course
            $course      = Course::find($request->course_id);
            // Check Enroll Course
            $checkenroll = $course->students->find( $user->id );

            // Check Course Enroll or not
            if ( ! $checkenroll ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You are unauthorized!",
                ];
            }

            // Get Lesson Id from request
            $request_lesson_id = $request->lesson_id;
            // Get Lesson Id from database
            $find_lesson_id    = $course->lessons()->where('id', $request_lesson_id)->get()->first();

            // Check Lesson
            if ( ! $find_lesson_id ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "Lesson not found!",
                ];
            }

            // Get User lesson from specific Course
            $lesson_user = LessonUser::where('course_id', $request->course_id)->where('lesson_id', $request->lesson_id)->where('student_id', $user->id)->get()->first();

            // Course Delete or Make as Incomplete
            if ( $lesson_user ) {
                $lesson_user->delete();
                // Response
                return [
                    'error'   => false,
                    'message' => "Lesson marked as incomplete!",
                ];
            }

            // Course Make as Complete
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
