<?php

namespace App\Http\Controllers;
use App\Services\UserService;

use Illuminate\Http\Request;

class SignupController extends Controller
{
    //
    protected $userservice;

  

public function __construct(UserService $userservice)
{
    $this->userservice = $userservice;
}
    public function index()
    {
        return view('signup');
    }

    public function store(Request $request)
    {
        $this->userservice->store($request->all());
         return redirect()->route('login.form');
    }


}
