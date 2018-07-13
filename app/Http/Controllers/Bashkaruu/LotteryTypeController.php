<?php

namespace App\Http\Controllers\Bashkaruu;

use App\Models\LotteryType;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;

class LotteryTypeController extends Controller
{
    public function index()
    {
        $lotteryTypes = LotteryType::all();
        return view('bashkaruu.lotteryTypes.index', compact('lotteryTypes'));
    }

    public function getLotteryTypes(Request $request)
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

        $resultPaginated = LotteryType::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
        foreach ($resultPaginated as $row) {
            $row->actions = '
                <a href="'.route('lotteryTypes.edit', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                    <i class="jam jam-write"></i>
                </a>
                <a href="'.route('lotteryTypes.delete', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
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
        $row = new LotteryType;
        return view('bashkaruu.lotteryTypes.create', 
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
        //
    }

    public function edit(LotteryType $lotteryType)
    {
        return view('bashkaruu.lotteryTypes.edit', 
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
