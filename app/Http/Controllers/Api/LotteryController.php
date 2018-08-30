<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\LotteryEdition;
use App\Models\SharedTicket;
use App\Models\SoldTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LotteryController extends Controller
{
    public function getActiveLotteriesWithEdition(Request $request)
    {
        $withEditions = $request->user()->getLotteriesWithEdition();

        foreach ($withEditions as $key => $row) {
            $soldTickets = DB::table('lottery_edition_'.$row->lottery_type.'_'.$row->number)->whereNotNull('sold_date')->get();
            $row->sold_tickets_count = count($soldTickets);
        }

        foreach ($withEditions as $key => $row) {
            $row->lottery_type = $row->getLotteryType()->name;
        }

        return response()->json(['data' => $withEditions], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getActiveLotteries(Request $request)
    {
        $lotteries = $request->user()->getLotteries();
        foreach ($lotteries as $key => $row) {
            $shared_count = $sold_count = 0;
            $row->lottery_type = $row->getLotteryType()->name;
            $sharedTickets = SharedTicket::where('user', $request->user()->id)->where('lottery', $row->id)->get();
            foreach ($sharedTickets as $key => $sharedTicket) {
                $shared_count += $sharedTicket->count;
            }
            $row->shared_count = $shared_count;
            $soldTickets = SoldTicket::where('user', $request->user()->id)->where('lottery', $row->id)->get();
            foreach ($soldTickets as $key => $soldTicket) {
                $sold_count += $soldTicket->count;
            }
            $row->sold_count = $sold_count;
        }

        return response()->json(['data' => $lotteries], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getTicketsWithEdition(Request $request)
    {
        $lotteryEdition = LotteryEdition::find($request->lottery_edition);
        $soldTickets = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
            ->whereNotNull('sold_date')
            ->orderBy('sold_date', 'desc')
            ->get();

        foreach ($soldTickets as $key => $row) {
            $row->lottery_edition_name = $lotteryEdition->getLotteryType()->name.': Тираж №'.$lotteryEdition->number;
            $row->sold_date = date("d.m.Y H:i", strtotime($row->sold_date));
        }

        return response()->json(['data' => $soldTickets], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getTickets(Request $request)
    {
        $lottery = Lottery::find($request->lottery);
        $soldTickets = SoldTicket::where('lottery', $request->lottery)
            ->whereNotNull('sold_date')
            ->orderBy('sold_date', 'desc')->get();

        foreach ($soldTickets as $key => $row) {
            $row->lottery_name = $lottery->name;
            $row->sold_date = date("d.m.Y", strtotime($row->sold_date));
        }

        return response()->json(['data' => $soldTickets], 200, [], JSON_NUMERIC_CHECK);
    }

    public function setTicketWithEdition(Request $request)
    {
        $date = date("Y-m-d H:i:s");

        $lotteryEdition = LotteryEdition::find($request->lottery);

        if($request->ticket_number > 9){
            $ticket_number = $request->ticket_number;
        } else {
            $ticket_number = str_pad($request->ticket_number, (strlen($lotteryEdition->tickets_count)-1), "0", STR_PAD_LEFT);
        }

        $soldTicket = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
            ->where('ticket_number', $ticket_number)->first();

        if($soldTicket){
            if($soldTicket->user != $request->user()->id){
                return response()->json(['message' => 'Билет с таким номером недоступен.'], 500);
            }
            if($soldTicket->sold_date){
                return response()->json(['message' => 'Билет с таким номером уже продан.'], 500);
            }
        } else {
            return response()->json(['message' => 'Билет с таким номером не существует.'], 500);
        }

        $ticket = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
            ->where('ticket_number', $ticket_number)
            ->update([
                'sold_date' => $date
            ]);

        if($ticket){
            return response()->json('success', 200, [], JSON_NUMERIC_CHECK);
        } else {
            return response()->json('error', 500);
        }        
    }

    public function setTicket(Request $request)
    {
        $date = date("Y-m-d H:i:s");

        $lottery = Lottery::find($request->lottery);

        $soldTicket = new SoldTicket;

        $soldTicket->count = $request->count;
        $soldTicket->user = $request->user()->id;
        $soldTicket->lottery = $request->lottery;
        $soldTicket->sold_date = $date;

        $soldTicket->save();

        if($soldTicket){
            return response()->json('success', 200, [], JSON_NUMERIC_CHECK);
        } else {
            return response()->json('error', 500);
        }  
    }
}