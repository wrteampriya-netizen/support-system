<?php

namespace App\Http\Controllers;
 use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    protected $userservice;



    public function __construct(UserService $userservice)
    {
        $this->userservice = $userservice;
    }
    public function index()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $data['remember']=$request->has('remmber');

       return $this->userservice->login($request->all());
    }
    
     public function password()
    {
        return view('forgetpass');
    }
    public function forgot(Request $request){
         return $this->userservice->forgetpassword($request->only('email'));
    }
    public function update_password(Request $request){
        $request->validate([
            'token'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:6|confirmed',

        ]);

        $status=Password::reset($request->only('email','password','password_confirmation','token'),function($user,$password){
            $user->password=Hash::make($password);
            $user->save();

        });

        return $status === Password::PASSWORD_RESET ? redirect('/login')->with('success','password resert successfully') 
        : back()->withErrors(['email'=>'reset email fail']) ;



    }
}
