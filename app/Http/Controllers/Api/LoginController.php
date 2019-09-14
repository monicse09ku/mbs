<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\UserResource;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class LoginController extends ApiBaseController
{
    /**
     * Api Login Process
     * @param  Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->respondValidationError('Parameters failed validation for a login');
        }

        try {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials)) {
                $user = auth()->user();
                $accessToken = $this->createAccessToken($user);

                return (new UserResource($user))->additional([
                    'token' => $accessToken,
                ]);
            }

            return $this->respondUnauthorized();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        try {
            event(new Registered($user = $this->create($request->all())));
            
            if ($user) {
                $accessToken = $this->createAccessToken($user);

                return (new UserResource($user))->additional([
                    'token' => $accessToken,
                ]);
            }

            return $this->respondUnauthorized();
        } catch (\Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'account_holder',
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Logout User
     * @param  Request $request
     * @return illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        if ($this->deleteAccessToken()) {
            return $this->respondSuccess('You have successfully logged out.');
        }

        return $this->respondInternalError('Failed to logout.');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateProfile(Request $request)
    {
        try {
            $update_array['name'] = $request->username;
            $update_array['email'] = $request->email;

            if (!empty($request->password)) {
                $update_array['password'] = bcrypt($request->password);
            }

            DB::table('users')
                ->where('id', $request->id)
                ->update(
                    $update_array
                );
            return $this->respondSuccess(SUCCESS);
        } catch (\Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
