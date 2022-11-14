<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
             'first_name' => ['required', 'string', 'max:255'],
             'last_name' => ['required', 'string', 'max:255'],

            'gender' => ['required'],
           'address' => ['required'],

        ]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return view('home',compact('user'));
    }
    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        $validate= $this->validator($request->all());

        if($validate->fails()){

            return redirect('home');
        }
        $data = $request->all();
        User::where('id',$user_id)->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
        ]);
        return redirect('home');
    }
}
