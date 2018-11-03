<?php

namespace App\Http\Controllers\Api;

use App\Models\InstantLottery;
use App\Models\SharedTicket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstantLotteryController extends Controller
{
    public function getInstantLotteries(Request $request)
    {
        $instantLotteries = $request->user()->getSellerInstantLotteries();

        foreach ($instantLotteries as $key => $row) {

            $sharedTickets = SharedTicket::where('lottery_id', $row->id)->where('seller_id', $request->user()->id)->whereNotNull('shared_to_seller_at')->first();
            $row->shared_count = $sharedTickets->tickets_count;
            $row->sold_count = $sharedTickets->sold_tickets_count;
        }

        return response()->json(['data' => $instantLotteries], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getSharedTickets(Request $request)
    {
        $lottery = InstantLottery::find($request->lottery_id);
        $soldTickets = SharedTicket::where('lottery_id', $request->lottery)
            ->whereNotNull('sold_at')
            ->where('seller_id')
            ->orderBy('sold_date', 'desc')->get();

        foreach ($soldTickets as $key => $row) {
            $row->lottery_name = $lottery->name;
            $row->sold_date = date("d.m.Y", strtotime($row->sold_date));
        }

        return response()->json(['data' => $soldTickets], 200, [], JSON_NUMERIC_CHECK);
    }
}
