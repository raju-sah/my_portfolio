<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('admin.profile.index', [
            'user' => auth()->user()
        ]);
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['name', 'new_password', 'confirm_password', 'current_password', 'image']);

        if ($request->new_password) {
            $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->password);

            if (!$currentPasswordStatus) {
                return redirect()->route('admin.profiles.index')->with('error', 'Current password does not match');
            }

            $data['password'] = Hash::make($request->new_password);
        }

        if ($request->hasFile('image')) {
            auth()->user()->updateImage('image', 'profile-images', $request->file('image'));
        }

        auth()->user()->update($data);

        return redirect()->route('admin.profiles.index')->with('success', 'Profile updated successfully');
    }
}



