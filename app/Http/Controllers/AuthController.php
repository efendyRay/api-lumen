<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Lumen Password Grant Client')->accessToken;

                return $this->return_success("Login successful", ["user" => $user, "token" => $token], Response::HTTP_OK);
            } else {
                return $this->return_mismatch("Password mismatch", Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
            return $this->return_mismatch("User does not exist", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());
        $token = $user->createToken('Lumen Password Grant Client')->accessToken;

        return $this->return_success("User created successfully", ["user" => $user, "token" => $token], Response::HTTP_CREATED);
    }
}
