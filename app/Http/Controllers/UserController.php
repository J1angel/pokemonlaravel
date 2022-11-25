<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function updateInformation(Request $request){
        $user = User::where('id', auth()->user()->id)->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->birthday = $request->birthday;
        $user->save();
        return $request->user();
    }


}
