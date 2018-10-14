<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstantLottery;
use App\Models\Lottery;
use App\Models\SharedTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class SharedTicketController extends Controller
{
    public function index()
    {
        //
    }

    public function getSharedTickets(Request $request)
    {
        $lottery = Lottery::find($request->lottery);
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
            $resultPaginated = SharedTicket::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
        } else {
            $resultPaginated = SharedTicket::orderBy('id', 'asc')->paginate($perpage);
        }

        foreach ($resultPaginated as $row) {
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
            $row->shared_user = $row->getSharedUser()->getFullName();
            $row->shared_at = $row->getCreatedDate().' '.$row->getCreatedTime();
            $row->actions = '
                <a href="'.route('sharedTickets.edit', [$lottery, $row->id]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                    <i class="jam jam-write"></i>
                </a>
                <a href="'.route('sharedTickets.delete',[$lottery, $row->id]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
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
    
    public function create(InstantLottery $instantLottery)
    {
        $sharedTicket = new SharedTicket;

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

        return redirect()->route('instantLottery.show', $instantLottery);
    }

    public function show(SharedTicket $sharedTicket)
    {
        //
    }

    public function edit(Lottery $lottery, SharedTicket $sharedTicket)
    {
        $availableTickets = $lottery->getAvailableTickets();
        if(auth()->user()->isAdmin() || auth()->user()->isStock()){
            $users = User::where('type', 3)->where('active', true)->pluck('name', 'id')->toArray();
        } else {
            $users = User::where('type', 2)->where('active', true)->pluck('name', 'id')->toArray();
        }
        return view('admin.lotteries.sharedTickets.edit', compact('sharedTicket', 'lottery', 'users', 'availableTickets'));
    }

    public function update(Request $request, Lottery $lottery, SharedTicket $sharedTicket)
    {
        $sharedTicket->update($request->except('user'));
        if(auth()->user()->isAdmin() || auth()->user()->isStock()){
            $sharedTicket->supervisor = $request->user;
        } else {
            $sharedTicket->user = $request->user;
        }
        $sharedTicket->save();
        return redirect()->route('lotteries.show', $lottery);
    }

    public function destroy(Lottery $lottery, SharedTicket $sharedTicket)
    {
        $sharedTicket->delete();
        return redirect()->route('lotteries.show', $lottery);
    }
}
