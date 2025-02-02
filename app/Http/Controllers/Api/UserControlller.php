<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserControlller extends Controller
{
    public function index(Request $request) {
        $users = User::orderBy('name', 'asc')->get();

        return response()->json($users);

    }


}
