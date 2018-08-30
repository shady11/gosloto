<?php

namespace App\Http\Controllers\Api;

use App\Models\LotteryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LotteryTypeController extends Controller
{
    public function lotteryTypes()
    {
        $lotteryTypes = LotteryType::where('active', true)->get();
        return response()->json(['data' => $lotteryTypes], 200, [], JSON_NUMERIC_CHECK);
    }
}
