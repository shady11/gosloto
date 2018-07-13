<?php

namespace App\Http\Controllers\Bashkaruu;

use App\Models\LotteryEdition;
use App\Models\LotteryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class LotteryEditionController extends Controller
{
    public function index()
    {
        $lotteryEditions = LotteryEdition::all();
        return view('bashkaruu.lotteryEditions.index', compact('lotteryEditions'));
    }

    public function getLotteryEditions(Request $request)
    {
        $pagination = $request->pagination;
        $sort = $request->sort;

        if($pagination['perpage']) { $perpage = $pagination['perpage']; } 
        else { $perpage = 2; }

        if($pagination['page']) { $page = $pagination['page']; } 
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $resultPaginated = LotteryEdition::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
        foreach ($resultPaginated as $row) {
            $row->lottery_type = $row->getLotteryType()->name;
            $row->actions = '
                <a href="'.route('lotteryEditions.edit', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                    <i class="jam jam-write"></i>
                </a>
                <a href="'.route('lotteryEditions.delete', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                    <i class="jam jam-trash-alt"></i>
                </a>
            ';
        }

        if($pagination['pages']) { $pages = $pagination['pages']; } 
        else { $pages = $resultPaginated->lastPage(); }

        if($pagination['total']) { $total = $pagination['total']; } 
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
        $lotteryEdition = new LotteryEdition;
        $lotteryTypes = LotteryType::where('active', true)->where('has_edition', true)->pluck('name', 'id')->toArray();
        return view('bashkaruu.lotteryEditions.create',
            compact(
                'lotteryEdition',
                'lotteryTypes'
            )
        );
    }

    public function store(Request $request)
    {
        $lotteryEdition = LotteryEdition::create($request->all());
        return redirect()->route('lotteryEditions.show', $lotteryEdition);
    }

    public function show(LotteryEdition $lotteryEdition)
    {
        return view('bashkaruu.lotteryEditions.show', compact('lotteryEdition'));
    }

    public function edit(LotteryEdition $lotteryEdition)
    {
        $lotteryTypes = LotteryType::where('active', true)->where('has_edition', true)->pluck('name', 'id')->toArray();
        return view('bashkaruu.lotteryEditions.edit', 
            compact(
                'lotteryEdition',
                'lotteryTypes'
            )
        );
    }

    public function update(Request $request, LotteryEdition $lotteryEdition)
    {
        $lotteryEdition->update($request->all());
        return redirect()->route('lotteryEditions.show', $lotteryEdition);
    }

    public function destroy(LotteryEdition $lotteryEdition)
    {
        $lotteryEdition->delete();
        return redirect()->route('lotteryEditions.index');
    }
}
