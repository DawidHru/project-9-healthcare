<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
=======
use App\Models\Patient;
>>>>>>> 9d34e96279d375f00c4c2fe3a3b91f47593c3fb0
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
<<<<<<< HEAD
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
=======
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Automatically create a Patient record for the new user
        Patient::create([
            'user_id' => $user->id,
            'date_of_birth' => $request->input('date_of_birth'), // Add this field to your registration form
            'gender' => $request->input('gender'), // Add this field to your registration form
            'address' => $request->input('address'), // Add this field to your registration form
            'phone' => $request->input('phone'), // Add this field to your registration form
            'emergency_contact' => $request->input('emergency_contact'), // Add this field to your registration form
            'blood_type' => $request->input('blood_type'), // Add this field to your registration form
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
>>>>>>> 9d34e96279d375f00c4c2fe3a3b91f47593c3fb0
    }
}
