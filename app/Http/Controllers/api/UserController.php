<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\UserResource;
use Database\Factories\CourseFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

Class UserController extends Controller {

    /**
     * Update User method.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateUser( Request $request )
    {
        // Validation
        $request->validate([
            'name'    => ['required', 'string', "min:6"],
        ]);

        try {
            $user = Auth::user();
            /** @var User $user */

            // If user loged in
            if ( ! $user ) {
                // Response
                return [
                    'error'   => true,
                    'message' => "You need to login!",
                ];
            }

            // $user Thumbnail
            $thumbnail = $user->thumbnail;

            // Delete old thumbnail and update with new one
            if ( !empty($request->file('thumbnail')) ) {
                Storage::delete('public/uploads/'.$thumbnail);

                $thumbnail = time() . '-' . $request->file('thumbnail')->getClientOriginalName();
                $request->file('thumbnail')->storeAs('public/uploads', $thumbnail);
            }

            // User Registration
            $user->update ([
                'name'      => $request->name,
                'thumbnail' => $thumbnail
            ]);

            // Response
            return [
                'error'   => false,
                'message' => "Profile Updated Successfully!",
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
     * myProfile method.
     *
     * @return \Illuminate\Http\Response
     */
    public function myProfile( )
    {

        try {
            $user = User::find( auth()->id() );
            /** @var User $user */

            // Response
            return [
                'error'             => false,
                'profile'           => new UserResource($user),
                'enroll_courses'    => collect($user->load('courses')->courses)->map(function($course) { return new CourseResource($course); }),
                'wishlist'          => collect($user->load('wishlist')->wishlist)->map(function($course) { return new CourseResource($course); }),
                'completed_courses' => collect( $user->courses()->wherePivot('status', 'complete')->get() )->map(function($course) { return new CourseResource($course); }),
            ];

        } catch (\Throwable $th) {
            return [
                'error'   => true,
                'message' => $th->getMessage(),
            ];
        }
    }

}
