<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
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

            if ( ! $user ) {
                return [
                    'error'   => true,
                    'message' => "You need to login!",
                ];
            }

            $thumbnail = $user->thumbnail;

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

            return [
                'error'   => false,
                'message' => "Profile Updated Successfully!",
            ];

        } catch (\Throwable $th) {
            return [
                'error'   => true,
                'message' => $th->getMessage(),
            ];
        }
    }

}
