<?php

namespace App\Http\Controllers\Admin;

use App\Models\LotteryType;
use App\Models\LotteryEdition;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;

class LotteryTypeController extends Controller
{
    public function index()
    {
        $lotteryTypes = LotteryType::all();
        return view('admin.lotteryTypes.index', compact('lotteryTypes'));
    }

    public function getLotteryTypes(Request $request)
    {
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
            $resultPaginated = LotteryType::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
        } else {
            $resultPaginated = LotteryType::orderBy('id', 'asc')->paginate($perpage);            
        }
        
        foreach ($resultPaginated as $row) {
            if($row->has_edition)
                $row->actions = '
                    <a href="'.route('lotteryTypes.show', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Показать">
                        <i class="jam jam-info"></i>
                    </a>
                    <a href="'.route('lotteryTypes.edit', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                        <i class="jam jam-write"></i>
                    </a>
                    <a href="'.route('lotteryTypes.delete', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                        <i class="jam jam-trash-alt"></i>
                    </a>
                ';
            else
                $row->actions = '
                    <a href="'.route('lotteries.show', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Показать">
                        <i class="jam jam-info"></i>
                    </a>
                    <a href="'.route('lotteries.edit', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                        <i class="jam jam-write"></i>
                    </a>
                    <a href="'.route('lotteries.delete', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                        <i class="jam jam-trash-alt"></i>
                    </a>
                ';
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

    public function getLotteryTypeEditions(Request $request){

        $lotteryType = LotteryType::find($request->lotteryType);

        $pagination = $request->pagination;
        $sort = $request->sort;

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; }
        else { $perpage = 2; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; }
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if(auth()->user()->isSupervisor()){
            if($sort){
                $resultPaginated = auth()->user()->getSupervisorLotteriesWithEdition($sort['field'], $sort['sort'], $perpage);
            }else {
                $resultPaginated = auth()->user()->getSupervisorLotteriesWithEdition('id', 'desc', $perpage);
            }
        } else {
            if($sort){
                $resultPaginated = LotteryEdition::where('lottery_type', $request->lotteryType)->orderBy($sort['field'], $sort['sort'])->paginate($perpage);
            }else {
                $resultPaginated = LotteryEdition::where('lottery_type', $request->lotteryType)->orderBy('number', 'desc')->paginate($perpage);
            }
        }

        foreach ($resultPaginated as $row) {
            $row->lottery_type = $row->getLotteryType()->name;
            if((auth()->user()->isAdmin()) || (auth()->user()->isStock())){
                $row->actions = '
                    <a href="'.route('lottery.lotteryEdition.show', [$lotteryType, $row]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Просмотр">
                        <i class="jam jam-info"></i>
                    </a>
                    <a href="'.route('lottery.lotteryEdition.edit', [$lotteryType, $row]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                        <i class="jam jam-write"></i>
                    </a>
                    <a href="'.route('lottery.lotteryEdition.delete', [$lotteryType, $row]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                        <i class="jam jam-trash-alt"></i>
                    </a>
                ';
            } elseif (auth()->user()->isSupervisor()) {
                $row->actions = '
                    <a href="'.route('lottery.lotteryEdition.show', [$row->getLotteryType(), $row]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Просмотр">
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
        $row = new LotteryType;
        return view('admin.lotteryTypes.create', 
            compact(
                'row'
            )
        );
    }

    public function store(Request $request)
    {
        $row = LotteryType::create($request->all());
        return redirect()->route('lotteryTypes.index');
    }

    public function show(LotteryType $lotteryType)
    {
        return view('admin.lotteryTypes.show', compact('lotteryType'));
    }

    public function edit(LotteryType $lotteryType)
    {
        return view('admin.lotteryTypes.edit', 
            compact(
                'lotteryType'
            )
        );
    }

    public function update(Request $request, LotteryType $lotteryType)
    {
        $lotteryType->update($request->all());
        return redirect()->route('lotteryTypes.index');
    }

    public function destroy(LotteryType $lotteryType)
    {
        $lotteryType->delete();
        return redirect()->route('lotteryTypes.index');
    }
}
