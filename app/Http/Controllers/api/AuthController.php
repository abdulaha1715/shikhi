<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;

Class AuthController extends Controller {

    /**
     * Register method.
     *
     * @return \Illuminate\Http\Response
     */
    public function register( Request $request )
    {
        // validation
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email',  'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        try {
            // User Registration
            $user = User::create ([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

             // Response
             return [
                'error'   => false,
                'message' => 'Registration Successfull!',
                'user'    => new UserResource( $user ),
                // 'verified' => 'A verification code has been send to your email'
            ];

            // Verify Code
            // $code = random_int(100000, 999999);

            // if ($user) {
                // Store Verify Code
                // UserVerification::create([
                //     'user_id' => $user->id,
                //     'code'    => $code,
                // ]);

                // Event Trigger
                // event(new Registered($user, $code));

                // Response
                // return [
                //     'error'    => false,
                //     'message'  => 'Registration Successfull!',
                //     'verified' => 'A verification code has been send to your email'
                // ];
            // }

        } catch (\Throwable $th) {
            // Response
            return [
                'error'    => true,
                'message'  => $th->getMessage(),
            ];
        }
    }

    /**
     * Login method.
     *
     * @return \Illuminate\Http\Response
     */
    public function login( Request $request )
    {
        // validation
        $request->validate([
            'email'    => ['required', 'string', 'email',  'max:255'],
            'password' => ['required'],
        ]);

        try {
            // User input check
            if ( !Auth::attempt($request->only('email', 'password'))) {
                // Response
                return [
                    'error'    => true,
                    'message'  => 'Email/Password error!',
                ];
            }

            $user = Auth::user();
            /** @var User $user */

            // Token
            $token = $user->createToken('authToken')->plainTextToken;

            // Response
            return [
                'error'   => false,
                'message' => 'Login Successful',
                'token'   => $token,
                'user'    => new UserResource( $user ),
            ];

            // if ( $user->hasVerifiedEmail() ) {
            //     $token = $user->createToken('authToken')->plainTextToken;
            //     // Response
            //     return [
            //         'error'   => false,
            //         'message' => 'Login Successful',
            //         'token'   => $token,
            //         'user'    => new UserResource( $user ),
            //     ];
            // } else {
            //     // Response
            //     return [
            //         'error'   => false,
            //         'message' => 'You need to verify your account',
            //     ];
            // }

        } catch (\Throwable $th) {
            // Response
            return [
                'error'    => true,
                'message'  => $th->getMessage(),
            ];
        }
    }

    /**
     * DeleteUser method.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteUser( Request $request )
    {
        try {

        } catch (\Throwable $th) {
            //

        }
    }

}
