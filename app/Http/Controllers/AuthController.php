<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Users;
use Hash;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.registration');
    }


    public function postLogin(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('login', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('index')->withSuccess("Zalogowano");
        }

        return redirect('login')->withError('Nieprawidłowe dane!');
    }


    public function postRegistration(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            're_password' => 'required|same:password',
            'phone' => 'required',
            'login' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        if (!$check) {
            return redirect("index")->withErrors('Podany login istnieje podaj inny login!')->withInput();
        }

        return redirect("index")->withSuccess('Great! You have Successfully loggedin');
    }


    public function dashboard()
    {
        if (Auth::check()) {
            return view('index');
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }


    public function create(array $data)
    {
        return Users::create([
            'login' => $data['login'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password'])
        ]);
    }


    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
