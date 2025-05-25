<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\Activity;

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
        $oldEmail = $user->email;
        
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            
            Activity::log(
                $user,
                'email_updated',
                $user,
                'Updated email address from ' . $oldEmail . ' to ' . $user->email
            );
        }

        if ($user->isDirty('name')) {
            Activity::log(
                $user,
                'name_updated',
                $user,
                'Updated name to ' . $user->name
            );
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's profile picture.
     */
    public function updatePicture(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_picture' => ['required', 'image', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
        }

        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user->profile_picture = basename($path);
        $user->save();

        Activity::log(
            $user,
            'profile_picture_updated',
            $user,
            'Updated profile picture'
        );

        return Redirect::route('profile.edit')->with('status', 'profile-picture-updated');
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

        Activity::log(
            $user,
            'account_deleted',
            $user,
            'Account deleted'
        );

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Delete the user's profile picture.
     */
    public function destroyPicture(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($user->profile_picture) {
            Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
            $user->update(['profile_picture' => null]);
            
            Activity::log(
                $user,
                'profile_picture_removed',
                $user,
                'Removed profile picture'
            );
            
            return redirect()->route('profile.edit')->with('status', 'profile-picture-removed');
        }
        
        return redirect()->route('profile.edit');
    }
}
