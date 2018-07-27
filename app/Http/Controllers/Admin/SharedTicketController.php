<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    
    public function create(Lottery $lottery)
    {
        $sharedTicket = new SharedTicket;
        $availableTickets = $lottery->getAvailableTickets();
        $users = User::where('type', 2)->where('active', true)->pluck('name', 'id')->toArray();
        return view('admin.lotteries.sharedTickets.create', compact('sharedTicket', 'lottery', 'users', 'availableTickets'));
    }

    public function store(Request $request, Lottery $lottery)
    {     
        $sharedTicket = SharedTicket::create($request->all());
        return redirect()->route('lotteries.show', $lottery);
    }

    public function show(SharedTicket $sharedTicket)
    {
        //
    }

    public function edit(Lottery $lottery, SharedTicket $sharedTicket)
    {
        $availableTickets = $lottery->getAvailableTickets();
        $users = User::where('type', 2)->where('active', true)->pluck('name', 'id')->toArray();
        return view('admin.lotteries.sharedTickets.edit', compact('sharedTicket', 'lottery', 'users', 'availableTickets'));
    }

    public function update(Request $request, Lottery $lottery, SharedTicket $sharedTicket)
    {
        $sharedTicket->update($request->all());
        return redirect()->route('lotteries.show', $lottery);
    }

    public function destroy(Lottery $lottery, SharedTicket $sharedTicket)
    {
        $sharedTicket->delete();
        return redirect()->route('lotteries.show', $lottery);
    }
}
