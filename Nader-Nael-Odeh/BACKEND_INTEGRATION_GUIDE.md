# Backend Integration Guide - Edit Lawyer Profile

## 📋 Form Data Structure

The edit-lawyer-profile form is now **100% backend-ready**. Here's what you need to know:

### Form Details
- **Method**: POST (with `@method('PUT')` for RESTful update)
- **Action**: Currently points to `route('lawyer-profile')` - update this to your actual endpoint
- **Enctype**: `multipart/form-data` (required for file upload)
- **CSRF**: Included via `@csrf` directive

---

## 📤 Form Fields (POST Data)

When the form is submitted, you'll receive these fields:

### Profile Picture
```php
$request->file('profile_picture')  // File upload (nullable)
$request->input('remove_profile_picture')  // "0" or "1" (string)
```

### Personal Information
```php
$request->input('full_name')       // string, required
$request->input('specialization')  // string, required (Criminal Law, Corporate Law, etc.)
$request->input('bio')             // string, required, max 500 chars
```

### Contact Information
```php
$request->input('email')           // string, required, valid email
$request->input('phone')           // string, required
$request->input('whatsapp')        // string, nullable
$request->input('linkedin')        // string, nullable, valid URL
```

---

## 🔧 Laravel Controller Example

### Route Definition
Update `routes/web.php`:
```php
Route::put('/lawyer/profile/update', [LawyerController::class, 'updateProfile'])
    ->name('lawyer.profile.update')
    ->middleware('auth');
```

Then update the form action in the Blade file:
```blade
action="{{ route('lawyer.profile.update') }}"
```

### Controller Method
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LawyerController extends Controller
{
    public function updateProfile(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'specialization' => 'required|string|in:Criminal Law,Corporate Law,Family Law,Real Estate,IP Law,Labor Law,Tax Law',
            'bio' => 'required|string|max:500',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'linkedin' => 'nullable|url|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
            'remove_profile_picture' => 'nullable|in:0,1',
        ]);

        $lawyer = auth()->user()->lawyer; // Assuming relationship exists

        // Handle profile picture
        if ($request->input('remove_profile_picture') == '1') {
            // Remove existing profile picture
            if ($lawyer->profile_picture) {
                Storage::disk('public')->delete($lawyer->profile_picture);
                $lawyer->profile_picture = null;
            }
        } elseif ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($lawyer->profile_picture) {
                Storage::disk('public')->delete($lawyer->profile_picture);
            }
            
            // Store new picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $lawyer->profile_picture = $path;
        }

        // Update other fields
        $lawyer->update([
            'full_name' => $validated['full_name'],
            'specialization' => $validated['specialization'],
            'bio' => $validated['bio'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'whatsapp' => $validated['whatsapp'],
            'linkedin' => $validated['linkedin'],
        ]);

        // Return response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $lawyer
            ]);
        }

        return redirect()->route('lawyer-profile')
            ->with('success', 'Profile updated successfully!');
    }
}
```

---

## 🗄️ Database Schema

Suggested migration for `lawyers` table:

```php
Schema::create('lawyers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('full_name');
    $table->string('specialization');
    $table->text('bio');
    $table->string('email')->unique();
    $table->string('phone');
    $table->string('whatsapp')->nullable();
    $table->string('linkedin')->nullable();
    $table->string('profile_picture')->nullable(); // Path to stored image
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->timestamps();
});
```

---

## 🎨 Frontend Integration

### Current State (Demo Mode)
The form currently shows a success toast and doesn't actually submit. This is controlled by:
```javascript
function handleProfileSubmit(event) {
    event.preventDefault();
    showToastMessage("Profile saved successfully!");
    return false; // Prevents submission
}
```

### To Enable Backend Submission

**Option 1: Standard Form Submission**
```javascript
function handleProfileSubmit(event) {
    // Just let the form submit naturally
    return true;
}
```

**Option 2: AJAX Submission (Better UX)**
Uncomment the AJAX code in the script section:
```javascript
const formData = new FormData(event.target);
fetch(event.target.action, {
    method: 'POST',
    body: formData,
    headers: {
        'X-Requested-With': 'XMLHttpRequest'
    }
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        showToastMessage("Profile updated successfully!");
        setTimeout(() => {
            window.location.href = "{{ route('lawyer-profile') }}";
        }, 1500);
    } else {
        showToastMessage("Error: " + (data.message || "Failed to update profile"));
    }
})
.catch(error => {
    showToastMessage("Error: " + error.message);
});
```

---

## ✅ Validation Messages

Add Laravel validation messages in your controller or form request:

```php
protected $messages = [
    'profile_picture.max' => 'Profile picture must be less than 5MB',
    'profile_picture.image' => 'Profile picture must be an image',
    'profile_picture.mimes' => 'Profile picture must be JPEG, PNG, JPG, or WebP',
    'bio.max' => 'Bio must not exceed 500 characters',
];
```

Display errors in Blade:
```blade
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

---

## 🔐 Security Checklist

- ✅ CSRF token included (`@csrf`)
- ✅ File upload validation (type, size)
- ✅ Input sanitization via Laravel validation
- ✅ Authentication middleware required
- ✅ Authorization check (user owns the profile)
- ✅ Secure file storage (use `storage/app/public`)

---

## 📝 Testing Checklist

- [ ] Upload new profile picture
- [ ] Remove profile picture
- [ ] Update all text fields
- [ ] Submit with invalid data (test validation)
- [ ] Submit with oversized image (>5MB)
- [ ] Submit with invalid file type
- [ ] Test CSRF protection
- [ ] Test unauthorized access

---

## 🚀 Quick Start

1. **Update the route** in `routes/web.php`
2. **Create the controller method** as shown above
3. **Run migration** for lawyers table
4. **Update form action** in Blade file
5. **Enable submission** by modifying `handleProfileSubmit()`
6. **Test** the form!

---

**Status**: ✅ **100% Backend Ready**

All form fields have proper `name` attributes, validation is client-side ready, and the structure follows Laravel best practices. Just connect your controller and you're good to go!
