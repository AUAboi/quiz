<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:users',
            'password' => 'required|confirmed|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return $user;
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            return Auth::user();
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function destroy($user_id)
    {
        if (User::find($user_id)->delete()) {
            return "Deleted successfully";
        }
        return "Error";
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|file'
        ]);


        Excel::import(new UsersImport, $request->file('file'));

        return 'Success';
    }
}
