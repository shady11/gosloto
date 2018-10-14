<?php

namespace App\Http\Controllers\Admin;

use App\Models\Draw;
use App\Models\DrawLottery;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DrawTicketController extends Controller
{
    public function index() {}

    public function create() {}

    public function store(Request $request) {}

    public function show(DrawLottery $drawLottery, Draw $draw, $id)
    {
        $ticket = DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->find($id);
        if(User::find($ticket->seller_id)){
            $seller = User::find($ticket->seller_id)->getFullName();
        } else {
            $seller = '-';
        }
        if(User::find($ticket->supervisor_id)){
            $supervisor = User::find($ticket->supervisor_id)->getFullName();
        } else {
            $supervisor = '-';
        }
        if(User::find($ticket->owner_id)){
            $owner = User::find($ticket->owner_id)->getFullName();
        } else {
            $owner = '-';
        }
        if($ticket->shared_to_supervisor_at){
            $ticket->shared_to_supervisor_at = date("d.m.Y H:i", strtotime($ticket->shared_to_supervisor_at));
        } else {
            $ticket->shared_to_supervisor_at = '-';
        }
        if($ticket->shared_to_seller_at){
            $ticket->shared_to_seller_at = date("d.m.Y H:i", strtotime($ticket->shared_to_seller_at));
        } else {
            $ticket->shared_to_seller_at = '-';
        }
        if($ticket->sold_at){
            $ticket->sold_at = date("d.m.Y H:i", strtotime($ticket->sold_at));
        } else {
            $ticket->sold_at = '-';
        }
        if($ticket->returned_at){
            $ticket->returned_at = date("d.m.Y H:i", strtotime($ticket->returned_at));
        } else {
            $ticket->returned_at = '-';
        }
        return view('admin.drawLottery.ticket.show',
            compact(
                'drawLottery',
                'draw',
                'ticket',
                'seller',
                'supervisor',
                'owner'
            )
        );
    }

    public function edit(DrawLottery $drawLottery, Draw $draw, $id)
    {
        $ticket = DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->find($id);
        $statuses = array(
            '0' => 'неактивный',
            '1' => 'выдан супервайзеру',
            '2' => 'выдан реализатору',
            '3' => 'продан',
            '4' => 'возврат',
        );
        $sellers = User::where('type', 2)->pluck('name', 'id')->toArray();
        $sellers = array_add($sellers, 0, 'не выбрано');
        $supervisors = User::where('type', 3)->pluck('name', 'id')->toArray();
        $supervisors = array_add($supervisors, 0, 'не выбрано');

        return view('admin.drawLottery.ticket.edit',
            compact(
                'drawLottery',
                'draw',
                'ticket',
                'statuses',
                'sellers',
                'supervisors'
            )
        );
    }

    public function update(Request $request, DrawLottery $drawLottery, Draw $draw, $id)
    {
        $ticket = DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->find($id);

        if($request->status == 4){
            DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->where('id', $id)->update([
                'status' => 4,
                'returned_at' => date("Y-m-d H:i:s")
            ]);
        } elseif($request->status == 3){
            if($request->sold_at) {
                DB::table($drawLottery->getNameSlugged() . '_' . $draw->draw_number)->where('id', $id)->update([
                    'status' => 3,
                    'sold_at' => $request->sold_at
                ]);
            } else {
                DB::table($drawLottery->getNameSlugged() . '_' . $draw->draw_number)->where('id', $id)->update([
                    'status' => 3,
                    'sold_at' => date("Y-m-d H:i:s")
                ]);
            }
        } elseif($request->status == 2){
            DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->where('id', $id)->update([
                'status' => 1,
                'seller_id' => $request->seller_id
            ]);
            if($ticket->seller_id != $request->seller_id){
                DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->where('id', $id)->update([
                    'shared_to_seller_at' => date("Y-m-d H:i:s")
                ]);
            }
        } elseif($request->status == 1){
            DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->where('id', $id)->update([
                'status' => 1,
                'supervisor_id' => $request->supervisor_id
            ]);
            if($ticket->supervisor_id != $request->supervisor_id){
                DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->where('id', $id)->update([
                    'shared_to_supervisor_at' => date("Y-m-d H:i:s")
                ]);
            }
        } else {
            DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->where('id', $id)->update([
                'status' => 0,
                'seller_id' => null,
                'supervisor_id' => null,
                'shared_to_supervisor_at' => null,
                'shared_to_seller_at' => null,
                'sold_at' => null,
                'returned_at' => null,
            ]);
        }

        return redirect()->route('drawLottery.draw.ticket.show', [$drawLottery, $draw, $id]);
    }

    public function destroy(DrawLottery $drawLottery, Draw $draw, $id)
    {
        DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->where('id', $id)->delete();
        $tickets = DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->get();
        $draw->tickets_count = $tickets->count();
        $draw->save();

        return redirect()->route('drawLottery.draw.show', [$drawLottery, $draw]);
    }

    public function ticketsAdd(DrawLottery $drawLottery, Draw $draw)
    {
        return view('admin.drawLottery.draw.ticketsAdd',
            compact(
                'drawLottery',
                'draw'
            )
        );
    }

    public function ticketsAddStore(Request $request, DrawLottery $drawLottery, Draw $draw)
    {
        set_time_limit(4000);

        $from = $request->ticketsFrom;
        $to = $request->ticketsTo;

        for($i = $from; $i < $to; $i++){
            DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->insert([
                'ticket_number' => str_pad($i, $draw->length, "0", STR_PAD_LEFT),
                'status' => 0,
                'draw_id' => $draw->id,
                'lottery_id' => $drawLottery->id,
                'owner_id' => auth()->user()->id
            ]);
        }

        $tickets = DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->get();
        $draw->tickets_count = $tickets->count();
        $draw->save();

        return redirect()->route('drawLottery.draw.show', [$drawLottery, $draw]);
    }

    public function ticketsShare(DrawLottery $drawLottery, Draw $draw)
    {
        $sellers = User::where('type', 2)->pluck('name', 'id')->toArray();
        $sellers = array_add($sellers, 0, 'не выбрано');
        $supervisors = User::where('type', 3)->pluck('name', 'id')->toArray();
        $supervisors = array_add($supervisors, 0, 'не выбрано');

        return view('admin.drawLottery.draw.ticketsShare',
            compact(
                'drawLottery',
                'draw',
                'sellers',
                'supervisors'
            )
        );
    }

    public function ticketsShareStore(Request $request, DrawLottery $drawLottery, Draw $draw)
    {
//        dd($request);
        set_time_limit(4000);

        $from = str_pad($request->ticketsFrom, $draw->length, "0", STR_PAD_LEFT);
        $to = str_pad($request->ticketsTo, $draw->length, "0", STR_PAD_LEFT);

        if($request->ticketsTo) {
            $tickets = DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->whereBetween('ticket_number', [$from, $to])->get();

            foreach ($tickets as $key => $row) {
                if($request->supervisor_id){
                    DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)
                        ->where('ticket_number', $row->ticket_number)
                        ->update([
                            'supervisor_id' => $request->supervisor_id,
                            'status' => 1,
                            'shared_to_supervisor_at' => date("Y-m-d H:i:s"),
                            'sold_at' => null,
                            'returned_at' => null,
                        ]);
                }
                if($request->seller_id){
                    DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)
                        ->where('ticket_number', $row->ticket_number)
                        ->update([
                            'seller_id' => $request->seller_id,
                            'status' => 2,
                            'shared_to_seller_at' => date("Y-m-d H:i:s"),
                            'sold_at' => null,
                            'returned_at' => null,
                        ]);
                }
            }

        } else {
            $ticket = DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->where('ticket_number', $from)->first();

            if($request->supervisor_id){
                DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)
                    ->where('ticket_number', $ticket->ticket_number)
                    ->update([
                        'supervisor_id' => $request->supervisor_id,
                        'status' => 1,
                        'shared_to_supervisor_at' => date("Y-m-d H:i:s"),
                        'sold_at' => null,
                        'returned_at' => null,
                    ]);
            }
            if($request->seller_id){
                DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)
                    ->where('ticket_number', $ticket->ticket_number)
                    ->update([
                        'seller_id' => $request->seller_id,
                        'status' => 2,
                        'shared_to_seller_at' => date("Y-m-d H:i:s"),
                        'sold_at' => null,
                        'returned_at' => null,
                    ]);
            }
        }

        return redirect()->route('drawLottery.draw.show', [$drawLottery, $draw]);
    }

    public function ticketsReturn(DrawLottery $drawLottery, Draw $draw)
    {
        $ticket = null;
        return view('admin.drawLottery.draw.ticketsReturn',
            compact(
                'drawLottery',
                'draw',
                'ticket'
            )
        );
    }

    public function ticketsReturnStore(Request $request, DrawLottery $drawLottery, Draw $draw)
    {
        $from = $request->ticketsFrom;
        $to = $request->ticketsTo;

        $tickets = DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->whereBetween('ticket_number', [$from, $to])->get();

        foreach ($tickets as $key => $row) {
            DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)
                ->where('ticket_number', $row->ticket_number)
                ->update([
                    'status' => 4,
                    'returned_at' => date("Y-m-d H:i:s")
                ]);
        }

        return redirect()->route('drawLottery.draw.show', [$drawLottery, $draw]);
    }

    public function ticketsReturnScan(DrawLottery $drawLottery, Draw $draw)
    {
        $ticket = null;
        return view('admin.drawLottery.draw.ticketsReturnScan',
            compact(
                'drawLottery',
                'draw',
                'ticket'
            )
        );
    }

    public function ticketsReturnScanStore(Request $request, DrawLottery $drawLottery, Draw $draw)
    {
        $ticket_number = $request->ticket_number;

        $ticket = DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->where('ticket_number', $ticket_number)->first();

        DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)
            ->where('ticket_number', $ticket_number)
            ->update([
                'status' => 4,
                'returned_at' => date("Y-m-d H:i:s")
            ]);

        return view('admin.drawLottery.draw.ticketsReturnScan',
            compact(
                'drawLottery',
                'draw',
                'ticket'
            )
        );
    }

    public function ticketsSold(DrawLottery $drawLottery, Draw $draw)
    {
        $tickets = DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->where('supervisor_id', auth()->user()->id)->where('status', 1)->orWhere('status', 2)->get();

        foreach ($tickets as $key => $row) {
            DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)
                ->where('ticket_number', $row->ticket_number)
                ->update([
                    'status' => 3,
                    'sold_at' => date("Y-m-d H:i:s")
                ]);
        }

        return redirect()->route('drawLottery.draw.show', [$drawLottery, $draw]);
    }
}