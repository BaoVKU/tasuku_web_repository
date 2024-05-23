<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GetStream\StreamChat\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthenticatedTokenController extends Controller
{
    //
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user, 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $request->user()->tokens()->delete();
            $bearer_token = $request->user()->createToken('api_token')->plainTextToken;

            $server_client = new Client("23hbg2r8hbdx", "7vsb5fb9kespn2447cj9hrjnjgp45nntt3rs8yhcs9uaf6jhpducbr3c6p24j32b");
            $jwt_token = $server_client->createToken($request->user()->id);

            return response()->json(['user' => auth()->user(), 'bearer' => $bearer_token, "jwt" => $jwt_token], 200);
        } else {
            return response()->json(['message' => 'Login failed'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(true, 200);
    }
}
