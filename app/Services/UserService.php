<?php

namespace App\Services;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    public function store(array $data)
    {
       

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
           

        ]);
        
            $user->assignRole('customer');
            
        


        return $user ? "register" : "not regitser";
    }
    public function login(array $data)
    {
        $role=($data['email']=== 'sita@gmail.com') ? 'admin':'user';

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        $remember= $data['remember'] ?? false ;
        if (Auth::attempt($credentials,$remember)) {
            request()->session()->regenerate();
            session(['user_id'=>auth::user()->id]);
            return redirect('/homepage');
        }


        return back()->with('error', 'invalid credentials');
    }
    




    
    public function forgetpassword(array $data)
    {
        $status = Password::sendResetLink($data);

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Reset link sent!')
            : back()->withErrors([
                'email' => 'Email not found'
            ]);
    }
}
