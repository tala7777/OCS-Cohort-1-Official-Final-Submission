<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show user dashboard (profile page)
     */
    public function index(Request $request): View
    {
        return view('frontend.profile', [
            'user' => $request->user()
        ]);
    }

    /**
     * Update profile info (modal form + camera button)
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // 1️⃣ Validation (مهم لزر الكاميرا)
        $request->validate([
            'name'          => 'sometimes|string|max:255',
            'email'         => 'sometimes|email',
            'bio'           => 'nullable|string',
            'skills'        => 'nullable|string',
            'location'      => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2️⃣ تحديث البيانات النصية (لو انبعثت)
        $user->update($request->only([
            'name',
            'email',
            'bio',
            'skills',
            'location',
        ]));

        // 3️⃣ رفع صورة البروفايل
        if ($request->hasFile('profile_photo')) {

            // حذف الصورة القديمة
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // تخزين الجديدة
            $path = $request->file('profile_photo')->store('profiles', 'public');

            $user->update([
                'profile_photo' => $path,
            ]);
        }

        return redirect()->route('profile')
            ->with('success', 'Profile updated successfully');
    }
}
