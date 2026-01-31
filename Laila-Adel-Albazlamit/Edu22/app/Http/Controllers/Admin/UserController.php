<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $users = User::where('role', '!=', 'admin')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        return view('admin.users.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['teacher', 'student'])],
            'class_id' => 'required_if:role,student|nullable|exists:classes,id',
            'section_id' => 'required_if:role,student|nullable|exists:sections,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'class_id' => $request->role === 'student' ? $request->class_id : null,
            'section_id' => $request->role === 'student' ? $request->section_id : null,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        if ($user->role === 'admin')
            abort(403);
        $classes = SchoolClass::all();
        $sections = Section::where('class_id', $user->class_id)->get();
        return view('admin.users.edit', compact('user', 'classes', 'sections'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role === 'admin')
            abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => ['required', Rule::in(['teacher', 'student'])],
            'class_id' => 'required_if:role,student|nullable|exists:classes,id',
            'section_id' => 'required_if:role,student|nullable|exists:sections,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'class_id' => $request->role === 'student' ? $request->class_id : null,
            'section_id' => $request->role === 'student' ? $request->section_id : null,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin')
            abort(403);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function getSections($classId)
    {
        $sections = Section::where('class_id', $classId)->get();
        return response()->json($sections);
    }
}
