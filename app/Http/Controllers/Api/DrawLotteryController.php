<?php

namespace App\Http\Controllers\Api;

use App\Models\Draw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DrawLotteryController extends Controller
{
    public function getDrawLotteries(Request $request)
    {
        $drawLotteries = $request->user()->getSellerDrawLotteries();

        foreach ($drawLotteries as $key => $row) {
            $soldTickets = DB::table('lottery_edition_'.$row->lottery_type.'_'.$row->number)->whereNotNull('sold_date')->get();
            $row->sold_tickets_count = count($soldTickets);
        }

        foreach ($drawLotteries as $key => $row) {
            $row->lottery_type = $row->getLotteryType()->name;
        }

        return response()->json(['data' => $drawLotteries], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getDraws(Request $request)
    {
        $drawLotteries = $request->user()->getSellerDrawLotteries();
        $draws = collect();

        foreach ($drawLotteries as $drawLottery)
        {
            $drawLotteryDraws = $request->user()->getSellerDraws($drawLottery->id);
            $draws = $draws->merge($drawLotteryDraws);
        }

        foreach ($draws as $draw) {
            $draw->sold_tickets_count = $draw->getSoldTicketsBySeller($request->user()->id)->count();
            $draw->seller_tickets_count = $draw->getTotalSellerTickets($request->user()->id)->count();
            $draw->lottery = $draw->getLottery->name;
        }

        return response()->json(['data' => $draws], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getDrawTickets(Request $request)
    {
        $draw = Draw::find($request->draw_id);
        $soldTickets = $draw->getSoldTicketsBySeller($request->user()->id);

        foreach ($soldTickets as $key => $row) {
            $row->sold_at = date("d.m.Y H:i", strtotime($row->sold_at));
        }

        return response()->json(['data' => $soldTickets], 200, [], JSON_NUMERIC_CHECK);
    }

    public function setDrawTicket(Request $request)
    {
        $date = date("Y-m-d H:i:s");

        $draw = Draw::find($request->draw_id);

        $ticket_number = $request->ticket_number;

        $soldTicket = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
            ->where('ticket_number', $ticket_number)->first();

        if($soldTicket){
            if($soldTicket->seller_id != $request->user()->id){
                return response()->json(['message' => 'Билет с таким номером недоступен.'], 500);
            }
            if($soldTicket->sold_at){
                return response()->json(['message' => 'Билет с таким номером уже продан.'], 500);
            }
        } else {
            return response()->json(['message' => 'Билет с таким номером не существует.'], 500);
        }

        $ticket = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
            ->where('ticket_number', $ticket_number)
            ->update([
                'sold_at' => $date,
                'status' => 3
            ]);

        if($ticket){
            return response()->json('success', 200, [], JSON_NUMERIC_CHECK);
        } else {
            return response()->json('error', 500);
        }
    }

    public function setDrawTickets(Request $request)
    {
        $date = date("Y-m-d H:i:s");

        $draw = Draw::find($request->draw_id);

        $ticket_number_from = $request->ticket_number_from;
        $ticket_number_to = $request->ticket_number_to;

        for($i = $ticket_number_from; $i<=$ticket_number_to; $i++){

            $soldTicket = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                ->where('ticket_number', $i)->first();

            if($soldTicket){
                if($soldTicket->seller_id != $request->user()->id){
                    return response()->json(['message' => 'Билет с номером '.$i.' недоступен.'], 500);
                }
                if($soldTicket->sold_at){
                    return response()->json(['message' => 'Билет с номером '.$i.' уже продан.'], 500);
                }
            } else {
                return response()->json(['message' => 'Билет с номером '.$i.' не существует.'], 500);
            }

            $ticket = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                ->where('ticket_number', $i)
                ->update([
                    'sold_at' => $date,
                    'status' => 3
                ]);
        }

        return response()->json('success', 200, [], JSON_NUMERIC_CHECK);
    }
}
