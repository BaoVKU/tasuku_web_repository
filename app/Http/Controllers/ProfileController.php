<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        switch ($user->gender) {
            case 0:
                $user->gender = "Male";
                break;
            case 1:
                $user->gender = "Female";
                break;

            default:
                $user->gender = 'Other';
                break;
        }
        if ($request->expectsJson())
            return response()->json($user);
        return view('profile.view', ['user' => $user]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'phone_number' => ['string', 'max:10', 'regex:/[0-9]{10}/'],
            'birthday' => ['date'],
            'gender' => ['min:0', 'max:2'],
            'address' => ['string'],
            'description' => ['string'],
            'avatar' => ['image', 'mimes:png,jpeg,jpg']
        ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        if ($request->hasFile('avatar'))
            $avatarPath = 'storage/' . $request->file('avatar')->store('avatars', 'public');
        else
            $avatarPath = $request->user()->avatar;
        User::where('id', $request->user()->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'address' => $request->address,
                'description' => $request->description,
                'avatar' => $avatarPath,
            ]);
        return back();
    }
    public function updateApi(Request $request)
    {
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        if ($request->hasFile('avatar'))
            $avatarPath = 'storage/' . $request->file('avatar')->store('avatars', 'public');
        else
            $avatarPath = $request->user()->avatar;

        $birthday = Carbon::createFromFormat('d/m/Y', $request->birthday)->format('Y-m-d');

        User::where('id', $request->user()->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phoneNumber,
                'birthday' => $birthday,
                'gender' => $request->gender,
                'address' => $request->address,
                'description' => $request->description,
                'avatar' => $avatarPath,
            ]);
        return response()->json(true, 200);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
