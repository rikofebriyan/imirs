<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $profiles = Profile::all();

        return view('auth.profile', compact('profiles'));
    }


    public function show(Profile $profile)
    {
        // Get the authenticated user
        $user = Auth::user();

        return view('profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        // Validate the form submission
        $request->validate([
            'profile_picture' => 'required|image|max:2048',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Delete the old profile picture (if it exists)
        if ($user->profile_picture) {
            Storage::delete('public/profile_pictures/' . $user->profile_picture);
        }

        // Save the new profile picture
        $path = $request->file('profile_picture')->store('public/profile_pictures');
        $filename = basename($path);

        // Update the user's profile picture in the database
        $user->profile_picture = $filename;
        $user->save();

        // Redirect the user back to the profile page
        return redirect()->route('profile')->with('success', 'Profile picture updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Delete the profile picture (if it exists)
        if ($user->profile_picture) {
            Storage::delete('public/profile_pictures/' . $user->profile_picture);
            $user->profile_picture = null;
            $user->save();
        }

        // Redirect the user back to the profile page
        return redirect()->route('profile')->with('success', 'Profile picture deleted successfully');
    }
}
