<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\LotteryType;
use App\Models\SharedTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class LotteryController extends Controller
{
    public function index()
    {
        $lotteries = Lottery::all();
        return view('admin.lotteries.index', compact('lotteries'));
    }

    public function getLotteries(Request $request)
    {
        $pagination = $request->pagination;
        $sort = $request->sort;

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; } 
        else { $perpage = 2; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; } 
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if($sort){
            $resultPaginated = Lottery::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
        }else {
            $resultPaginated = Lottery::orderBy('id', 'desc')->paginate($perpage);            
        }

        foreach ($resultPaginated as $row) {
            $row->lottery_type = $row->getLotteryType()->name;
            if((auth()->user()->isAdmin()) || (auth()->user()->isStock())){
                $row->actions = '
                <a href="'.route('lotteries.show', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Просмотр">
                    <i class="jam jam-info"></i>
                </a>
                <a href="'.route('lotteries.edit', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                    <i class="jam jam-write"></i>
                </a>
                <a href="'.route('lotteries.delete', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                    <i class="jam jam-trash-alt"></i>
                </a>
            ';
            } elseif (auth()->user()->isSupervisor()) {
                $row->actions = '
                <a href="'.route('lotteries.show', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Просмотр">
                    <i class="jam jam-info"></i>
                </a>
            ';
            }

        }

        if(array_key_exists('pages', $pagination)) { $pages = $pagination['pages']; } 
        else { $pages = $resultPaginated->lastPage(); }

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

    public function create()
    {
        $lottery = new Lottery;
        $lotteryTypes = LotteryType::where('active', true)->where('has_edition', false)->pluck('name', 'id')->toArray();
        return view('admin.lotteries.create',
            compact(
                'lottery',
                'lotteryTypes'
            )
        );
    }

    public function store(Request $request)
    {
        $lottery = Lottery::create($request->all());

        return redirect()->route('lotteries.show', $lottery);
    }

    public function show(Lottery $lottery)
    {
        return view('admin.lotteries.show', compact('lottery'));
    }

    public function edit(Lottery $lottery)
    {
        $lotteryTypes = LotteryType::where('active', true)->where('has_edition', false)->pluck('name', 'id')->toArray();
        return view('admin.lotteries.edit', 
            compact(
                'lottery',
                'lotteryTypes'
            )
        );
    }

    public function update(Request $request, Lottery $lottery)
    {
        $lottery->update($request->all());
        return redirect()->route('lotteries.show', $lottery);
    }

    public function destroy(Lottery $lottery)
    {
        $sharedTickets = SharedTicket::where('lottery', $lottery->id)->get();
        foreach ($sharedTickets as $row) {
            $row->delete();
        }
        $lottery->delete();
        return redirect()->route('lotteries.index');
    }
}
