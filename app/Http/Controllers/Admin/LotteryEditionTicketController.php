<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LotteryEdition;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class LotteryEditionTicketController extends Controller
{
    public function getLotteryEditionTickets(Request $request)
    {
        $lotteryEdition = LotteryEdition::find($request->lotteryEdition);
        $pagination = $request->pagination;
        $sort = $request->sort;

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; } 
        else { $perpage = 10; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; } 
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if($sort){
            $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                ->orderBy($sort['field'], $sort['sort'])
                ->paginate($perpage);
        } else {
            $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                ->orderBy('ticket_number', 'asc')
                ->paginate($perpage);
        }

        foreach ($resultPaginated as $row) {
            $row->lottery_edition = $lotteryEdition->number;
            if($row->sold_date){
                $row->sold_date = date("d.m.Y H:i", strtotime($row->sold_date));
            } else {
                $row->sold_date = '-';
            }
            $user = User::where('id',$row->user)->first();
            if(!empty($user)){
                $row->user = $user->getFullName();
            } else {
                $row->user = '-';
            }
            $row->actions = '
                <a href="'.route('lotteryEditionTickets.edit', [$lotteryEdition, $row->id]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                    <i class="jam jam-write"></i>
                </a>
                <a href="'.route('lotteryEditionTickets.delete',[$lotteryEdition, $row->id]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                    <i class="jam jam-trash-alt"></i>
                </a>
            ';
        }

        if(array_key_exists('pages', $pagination)) {
            $pages = $pagination['pages']; 
        } else { 
            $pages = $resultPaginated->lastPage(); 
        }

        if(array_key_exists('total', $pagination)) { $total = $pagination['total']; } 
        else { $total = $resultPaginated->total(); }

        $meta = array(
            'page' => $page,
            'pages' => $pages,
            'perpage' => $perpage,
            'total' => $total
        );

        $result = array('meta' => $meta, 'data' => $resultPaginated->all());
        return json_encode($result);
    }

    public function getLotteryTicketsTo(Request $request)
    {
        $lotteryEdition = LotteryEdition::find($request->lotteryEdition);
        $lotteryEditionTickets = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
            ->where('ticket_number', '>', $request->ticketNumber)
            ->where('user', NULL)
            ->get();

        $result = '';

        $step = Setting::where('slug', 'tickets')->first()->getBody()->value;

        for($i = $request->ticketNumber; $i < $lotteryEdition->tickets_count; $i+=$step){
            if($lotteryEditionTickets->contains('ticket_number', $i+$step-1)){
                $result .= '
                    <option value="'.($i+$step-1).'" >
                        '.($i+$step-1).'
                    </option>
                ';                
            } else {
                break;
            }
        }

        return $result;
    }

    public function addUser(Request $request, LotteryEdition $lotteryEdition)
    {
        $users = User::where('type', 2)->where('active', true)->pluck('name', 'id')->toArray();
        $lotteryEditionTickets = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->where('user', NULL)->get();
        $step = Setting::where('slug', 'tickets')->first()->getBody()->value;

        return view('admin.lotteryEditions.tickets.addUser', compact('lotteryEdition', 'users', 'lotteryEditionTickets', 'step'));
    }

    public function addUserStore(Request $request)
    {      
        set_time_limit(4000);

        $lotteryEdition = LotteryEdition::where('number', $request->number)->first();
        
        $from = $request->lotteryTicketsFrom;
        $to = $request->lotteryTicketsTo - 1;

        $user = User::find($request->user);

        $tickets = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->whereBetween('ticket_number', [$from, $to])->get();

        foreach ($tickets as $key => $row) {
            DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                ->where('ticket_number', $row->ticket_number)
                ->update([
                    'user' => $request->user,
                    'active' => true
                ]);
        }

        return redirect()->route('lotteryEditions.show', $lotteryEdition);
    }

    public function create()
    {
        dd('create');
    }

    public function store(Request $request)
    {
        dd('store');
    }

    public function show($id)
    {
        dd('show');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        dd(update);
    }

    public function destroy($id)
    {
        //
    }
}
