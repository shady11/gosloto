<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function user(Request $request)
    {
        $user = $request->user();
        $url = URL::to('/');

        $user->avatar = $url.'/'.$user->avatar;

        if($user){
            return response()->json(['data' => $user], 200, [], JSON_NUMERIC_CHECK);
        } else {
            return response()->json(['message' => 'Пользователь не существует.'], 500);
        }
    }
}