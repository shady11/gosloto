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
        $query = $request->input('query');

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; } 
        else { $perpage = 10; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; } 
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if($query){
            if(auth()->user()->isSupervisor()){
                if(array_key_exists('generalSearch', $query)){
                    if($sort){
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('supervisor', auth()->user()->id)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch'].'%')
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('supervisor', auth()->user()->id)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch'].'%')
                            ->orderBy('ticket_number', 'asc')
                            ->paginate($perpage);
                    }
                } else {
                    if($sort){
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('supervisor', auth()->user()->id)
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('supervisor', auth()->user()->id)
                            ->orderBy('ticket_number', 'asc')
                            ->paginate($perpage);
                    }
                }
            } else {
                if(array_key_exists('generalSearch', $query)){
                    if($sort){
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch'].'%')
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch'].'%')
                            ->orderBy('ticket_number', 'asc')
                            ->paginate($perpage);
                    }
                } else {
                    if($sort){
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->orderBy('ticket_number', 'asc')
                            ->paginate($perpage);
                    }
                }
            }
        } else {
            if(auth()->user()->isSupervisor()){
                if($sort){
                    $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                        ->where('supervisor', auth()->user()->id)
                        ->orderBy($sort['field'], $sort['sort'])
                        ->paginate($perpage);
                } else {
                    $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                        ->where('supervisor', auth()->user()->id)
                        ->orderBy('ticket_number', 'asc')
                        ->paginate($perpage);
                }
            } else {
                if($sort){
                    $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                        ->orderBy($sort['field'], $sort['sort'])
                        ->paginate($perpage);
                } else {
                    $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                        ->orderBy('ticket_number', 'asc')
                        ->paginate($perpage);
                }
            }
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
            $supervisor = User::where('id',$row->supervisor)->first();
            if(!empty($supervisor)){
                $row->supervisor = $supervisor->getFullName();
            } else {
                $row->supervisor = '-';
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

    public function getLotteryEditionTicketsBack(Request $request)
    {
        $lotteryEdition = LotteryEdition::find($request->lotteryEdition);
        $pagination = $request->pagination;
        $sort = $request->sort;
        $query = $request->input('query');

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; }
        else { $perpage = 10; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; }
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if($query){
            if(auth()->user()->isSupervisor()){
                if(array_key_exists('generalSearch', $query)){
                    if($sort){
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('return', true)
                            ->where('supervisor', auth()->user()->id)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch'].'%')
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('return', true)
                            ->where('supervisor', auth()->user()->id)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch'].'%')
                            ->orderBy('id', 'asc')
                            ->paginate($perpage);
                    }
                } else {
                    if($sort){
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('return', true)
                            ->where('supervisor', auth()->user()->id)
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('return', true)
                            ->where('supervisor', auth()->user()->id)
                            ->orderBy('id', 'asc')
                            ->paginate($perpage);
                    }
                }
            } else {
                if(array_key_exists('generalSearch', $query)){
                    if($sort){
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('return', true)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch'].'%')
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('return', true)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch'].'%')
                            ->orderBy('id', 'asc')
                            ->paginate($perpage);
                    }
                } else {
                    if($sort){
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('return', true)
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                            ->where('return', true)
                            ->orderBy('id', 'asc')
                            ->paginate($perpage);
                    }
                }
            }
        } else {
            if(auth()->user()->isSupervisor()){
                if($sort){
                    $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                        ->where('return', true)
                        ->where('supervisor', auth()->user()->id)
                        ->orderBy($sort['field'], $sort['sort'])
                        ->paginate($perpage);
                } else {
                    $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                        ->where('return', true)
                        ->where('supervisor', auth()->user()->id)
                        ->orderBy('id', 'asc')
                        ->paginate($perpage);
                }
            } else {
                if($sort){
                    $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                        ->where('return', true)
                        ->orderBy($sort['field'], $sort['sort'])
                        ->paginate($perpage);
                } else {
                    $resultPaginated = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                        ->where('return', true)
                        ->orderBy('id', 'asc')
                        ->paginate($perpage);
                }
            }
        }

        foreach ($resultPaginated as $row) {
            $row->lottery_edition = $lotteryEdition->number;
            if($row->return_date){
                $row->return_date = date("d.m.Y H:i", strtotime($row->return_date));
            } else {
                $row->return_date = '-';
            }
            $user = User::where('id',$row->user)->first();
            if(!empty($user)){
                $row->user = $user->getFullName();
            } else {
                $row->user = '-';
            }
            $supervisor = User::where('id',$row->supervisor)->first();
            if(!empty($supervisor)){
                $row->supervisor = $supervisor->getFullName();
            } else {
                $row->supervisor = '-';
            }
            $row->actions = '
                <a href="'.route('lotteryEditionTickets.ticketReturn.delete',[$lotteryEdition, $row->id]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
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
        if(auth()->user()->isAdmin() || auth()->user()->isStock()){
            $users = User::where('type', 3)->where('active', true)->pluck('name', 'id')->toArray();
            $lotteryEditionTickets = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->where('user', NULL)->orderBy('ticket_number', 'asc')->get();
        } elseif(auth()->user()->isSupervisor()) {
            $users = User::where('type', 2)->where('active', true)->pluck('name', 'id')->toArray();
            $lotteryEditionTickets = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->where('supervisor', auth()->user()->id)->where('user', NULL)->orderBy('ticket_number', 'asc')->get();
        } else {
            $users = User::where('type', 2)->where('active', true)->pluck('name', 'id')->toArray();
            $lotteryEditionTickets = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->where('user', NULL)->orderBy('ticket_number', 'asc')->get();
        }

        return view('admin.lotteryEditions.tickets.addUser', compact('lotteryEdition', 'users', 'lotteryEditionTickets', 'step'));
    }

    public function addTickets(Request $request, LotteryEdition $lotteryEdition)
    {
        return view('admin.lotteryEditions.tickets.addTickets', compact('lotteryEdition'));
    }

    public function addTicketsBack(Request $request, LotteryEdition $lotteryEdition)
    {
        $ticket_number = null;
        return view('admin.lotteryEditions.tickets.addTicketsBack', compact('lotteryEdition', 'ticket_number'));
    }

    public function addUserStore(Request $request, LotteryEdition $lotteryEdition)
    {
//        dd($request, $lotteryEdition);
        set_time_limit(4000);
        
        $from = $request->lotteryTicketsFrom;
        $to = $request->lotteryTicketsTo;

        if($to) {
            $tickets = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->whereBetween('ticket_number', [$from, $to])->get();

            foreach ($tickets as $key => $row) {
                if(auth()->user()->isAdmin() || auth()->user()->isStock()){
                    DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                        ->where('ticket_number', $row->ticket_number)
                        ->update([
                            'supervisor' => $request->user,
                            'active' => true
                        ]);
                } else {
                    DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                        ->where('ticket_number', $row->ticket_number)
                        ->update([
                            'user' => $request->user,
                            'active' => true
                        ]);
                }
            }
        } else {
            $ticket = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->where('ticket_number', $from)->first();

            if(auth()->user()->isAdmin() || auth()->user()->isStock()){
                DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                    ->where('ticket_number', $ticket->ticket_number)
                    ->update([
                        'supervisor' => $request->user,
                        'active' => true
                    ]);
            } else {
                DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                    ->where('ticket_number', $ticket->ticket_number)
                    ->update([
                        'user' => $request->user,
                        'active' => true
                    ]);
            }
        }

        return redirect()->route('lotteryEditions.show', $lotteryEdition);
    }

    public function addTicketsStore(Request $request, LotteryEdition $lotteryEdition)
    {
//        dd($request, $lotteryEdition);
        set_time_limit(4000);

        $from = str_pad($request->lotteryTicketsFrom, (strlen($request->lotteryTicketsTo)), "0", STR_PAD_LEFT);
        $to = str_pad(($request->lotteryTicketsTo - 1), (strlen($request->lotteryTicketsTo)), "0", STR_PAD_LEFT);

        for($i = $from; $i <= $to; $i++){
            DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->insert([
                'ticket_number' => str_pad($i, (strlen($request->lotteryTicketsTo)), "0", STR_PAD_LEFT),
                'lottery_edition' => $lotteryEdition->id
            ]);
        }

        $lotteryEdition->tickets_count = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->get()->count();
        $lotteryEdition->save();

        return redirect()->route('lotteryEditions.show', $lotteryEdition);
    }

    public function addTicketsBackStore(Request $request, LotteryEdition $lotteryEdition)
    {
//        $ticket_number = "00";
        $ticket_number = $request->ticket_number;

        DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
            ->where('ticket_number', $ticket_number)
            ->update([
                'active' => false,
                'return' => true,
                'return_date' => date("Y-m-d H:i:s")
            ]);

        return view('admin.lotteryEditions.tickets.addTicketsBack', compact('lotteryEdition', 'ticket_number'));
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

    public function edit(LotteryEdition $lotteryEdition, $id)
    {
        if(auth()->user()->isAdmin() || auth()->user()->isStock()){
            $users = User::where('type', 3)->where('active', true)->pluck('name', 'id')->toArray();
        } elseif(auth()->user()->isSupervisor()) {
            $users = User::where('type', 2)->where('active', true)->pluck('name', 'id')->toArray();
        } else {
            $users = User::where('type', 2)->where('active', true)->pluck('name', 'id')->toArray();
        }
        $users = array_add($users,  0, 'не выбрано');
        $ticket = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->where('id', $id)->first();
        return view('admin.lotteryEditions.tickets.edit', 
            compact(
                'lotteryEdition',
                'users',
                'ticket'
            )
        );
    }

    public function update(Request $request, LotteryEdition $lotteryEdition, $id)
    {
        if($request->user){
            if(auth()->user()->isAdmin() || auth()->user()->isStock()){
                $ticket = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                    ->where('id', $id)
                    ->update([
                        'supervisor' => $request->user,
                        'sold_date' => $request->sold_date
                    ]);
            } else {
                $ticket = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                    ->where('id', $id)
                    ->update([
                        'user' => $request->user,
                        'sold_date' => $request->sold_date
                    ]);
            }
        } else {
            if(auth()->user()->isAdmin() || auth()->user()->isStock()){
                $ticket = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                    ->where('id', $id)
                    ->update([
                        'supervisor' => null,
                        'active' => false,
                        'sold_date' => $request->sold_date
                    ]);
            } else {
                $ticket = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
                    ->where('id', $id)
                    ->update([
                        'user' => null,
                        'active' => false,
                        'sold_date' => $request->sold_date
                    ]);
            }
        }

        return redirect()->route('lotteryEditions.show', $lotteryEdition);
    }

    public function destroy($id)
    {
        dd($id);
    }

    public function deleteTicketReturn(Request $request, LotteryEdition $lotteryEdition, $id)
    {
        $ticket = DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)
            ->where('id', $id)
            ->update([
                'active' => true,
                'return' => false,
                'return_date' => null
            ]);

        return redirect()->route('lotteryEditions.show', $lotteryEdition);
    }
}
