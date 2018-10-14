<?php

namespace App\Http\Controllers\Admin;

use App\Models\InstantLottery;
use App\Models\SharedTicket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstantLotterySharedTicketController extends Controller
{
    public function index()
    {
        //
    }

    public function create(InstantLottery $instantLottery)
    {
        $sharedTicket = new SharedTicket();

        $availableTickets = $instantLottery->getAvailableTickets();

        $sellers = User::where('type', 2)->pluck('name', 'id')->toArray();
        $sellers = array_add($sellers, 0, 'не выбрано');
        $supervisors = User::where('type', 3)->pluck('name', 'id')->toArray();
        $supervisors = array_add($supervisors, 0, 'не выбрано');

        return view('admin.instantLottery.sharedTicket.create',
            compact(
                'sharedTicket',
                'instantLottery',
                'sellers',
                'supervisors',
                'availableTickets'
            )
        );
    }

    public function store(Request $request, InstantLottery $instantLottery)
    {
        $sharedTicket = SharedTicket::create($request->all());
        if($request->supervisor_id) $sharedTicket->shared_to_supervisor_at = date("Y-m-d H:i:s");
        if($request->seller_id) $sharedTicket->shared_to_seller_at = date("Y-m-d H:i:s");
        $sharedTicket->save();
        return redirect()->route('instantLottery.show', $instantLottery);
    }

    public function show(InstantLottery $instantLottery, SharedTicket $sharedTicket)
    {
        if($sharedTicket->shared_to_supervisor_at)
            $sharedTicket->shared_to_supervisor_at = date("d.m.Y H:i", strtotime($sharedTicket->shared_to_supervisor_at));
        else
            $sharedTicket->shared_to_supervisor_at = '-';

        if($sharedTicket->shared_to_seller_at)
            $sharedTicket->shared_to_seller_at = date("d.m.Y H:i", strtotime($sharedTicket->shared_to_seller_at));
        else
            $sharedTicket->shared_to_seller_at = '-';

        if($sharedTicket->sold_at)
            $sharedTicket->sold_at = date("d.m.Y H:i", strtotime($sharedTicket->sold_at));
        else
            $sharedTicket->sold_at = '-';

        if($sharedTicket->returned_at)
            $sharedTicket->returned_at = date("d.m.Y H:i", strtotime($sharedTicket->returned_at));
        else
            $sharedTicket->returned_at = '-';

        return view('admin.instantLottery.sharedTicket.show',
            compact(
                'sharedTicket',
                'instantLottery'
            )
        );
    }

    public function edit(InstantLottery $instantLottery, SharedTicket $sharedTicket)
    {
        $availableTickets = $instantLottery->getAvailableTickets();

        $sellers = User::where('type', 2)->pluck('name', 'id')->toArray();
        $sellers = array_add($sellers, 0, 'не выбрано');
        $supervisors = User::where('type', 3)->pluck('name', 'id')->toArray();
        $supervisors = array_add($supervisors, 0, 'не выбрано');

        return view('admin.instantLottery.sharedTicket.edit',
            compact(
                'sharedTicket',
                'instantLottery',
                'sellers',
                'supervisors',
                'availableTickets'
            )
        );
    }

    public function update(Request $request, InstantLottery $instantLottery, SharedTicket $sharedTicket)
    {
        $sharedTicket->update($request->all());
        return redirect()->route('instantLottery.show', $instantLottery);
    }

    public function destroy(InstantLottery $instantLottery, SharedTicket $sharedTicket)
    {
        $sharedTicket->delete();
        return redirect()->route('instantLottery.show', $instantLottery);
    }

    public function ticketsSold(InstantLottery $instantLottery, SharedTicket $sharedTicket)
    {
        return view('admin.instantLottery.sharedTicket.ticketsSold',
            compact(
                'instantLottery',
                'sharedTicket'
            )
        );
    }

    public function ticketsSoldStore(Request $request, InstantLottery $instantLottery, SharedTicket $sharedTicket)
    {
        $sharedTicket->sold_tickets_count = $request->sold_tickets_count;
        $sharedTicket->sold_at = date("Y-m-d H:i:s");
        $sharedTicket->save();
        return redirect()->route('instantLottery.sharedTicket.show', [$instantLottery, $sharedTicket]);
    }

    public function ticketsReturned(InstantLottery $instantLottery, SharedTicket $sharedTicket)
    {
        return view('admin.instantLottery.sharedTicket.ticketsReturned',
            compact(
                'instantLottery',
                'sharedTicket'
            )
        );
    }

    public function ticketsReturnedStore(Request $request, InstantLottery $instantLottery, SharedTicket $sharedTicket)
    {
        $sharedTicket->returned_tickets_count = $request->returned_tickets_count;
        $sharedTicket->returned_at = date("Y-m-d H:i:s");
        $sharedTicket->save();
        return redirect()->route('instantLottery.sharedTicket.show', [$instantLottery, $sharedTicket]);
    }
}
