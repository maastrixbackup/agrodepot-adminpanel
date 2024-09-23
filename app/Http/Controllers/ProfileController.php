<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileImageUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
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
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // if ($request->file('image') == null) {
        //     $input['image'] = $user->prof_img;
        // } else {
        //     $destinationPath = '/uploads/adminprofile';
        //     $imgfile = $request->file('image');
        //     $imgFilename = $imgfile->getClientOriginalName();
        //     $imgfile->move(public_path() . $destinationPath, $imgfile->getClientOriginalName());
        //     $image = $imgFilename;
        //     $user->prof_img = $image;
        // }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function profileImageUpdate(ProfileImageUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        if ($request->file('image') == null) {
            $input['image'] = $user->prof_img;
        } else {
            $destinationPath = '/uploads/adminprofile';
            $imgfile = $request->file('image');
            $imgFilename = $imgfile->getClientOriginalName();
            $imgfile->move(public_path() . $destinationPath, $imgfile->getClientOriginalName());
            $image = $imgFilename;
            $user->prof_img = $image;
        }

        $user->fill($validated);

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-image-updated');
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
