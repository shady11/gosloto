<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LotteryEdition;
use App\Models\LotteryType;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LotteryEditionController extends Controller
{
    public function index()
    {
        $lotteryEditions = LotteryEdition::all();
        return view('admin.lotteryEditions.index', compact('lotteryEditions'));
    }

    public function getLotteryEditions(Request $request)
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

        if(auth()->user()->isSupervisor()){
            if($sort){
//                dd(auth()->user()->getSupervisorLotteriesWithEdition($sort['field'], $sort['sort']));
                $resultPaginated = auth()->user()->getSupervisorLotteriesWithEdition($sort['field'], $sort['sort'], $perpage);
            }else {
//                dd(auth()->user()->getSupervisorLotteriesWithEdition('id', 'desc'));
                $resultPaginated = auth()->user()->getSupervisorLotteriesWithEdition('id', 'desc', $perpage);
            }
        } else {
            if($sort){
                $resultPaginated = LotteryEdition::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
            }else {
                $resultPaginated = LotteryEdition::orderBy('id', 'desc')->paginate($perpage);
            }
        }

//        if($sort){
//            $resultPaginated = LotteryEdition::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
//        }else {
//            $resultPaginated = LotteryEdition::orderBy('id', 'desc')->paginate($perpage);
//        }

        foreach ($resultPaginated as $row) {
            $row->lottery_type = $row->getLotteryType()->name;
            if((auth()->user()->isAdmin()) || (auth()->user()->isStock())){
                $row->actions = '
                    <a href="'.route('lottery.lotteryEdition.show', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Просмотр">
                        <i class="jam jam-info"></i>
                    </a>
                    <a href="'.route('lottery.lotteryEdition.edit', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                        <i class="jam jam-write"></i>
                    </a>
                    <a href="'.route('lottery.lotteryEdition.delete', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                        <i class="jam jam-trash-alt"></i>
                    </a>
                ';
            } elseif (auth()->user()->isSupervisor()) {
                $row->actions = '
                    <a href="'.route('lottery.lotteryEdition.show', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Просмотр">
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
        $lotteryEdition = new LotteryEdition;
        $lotteryTypes = LotteryType::where('active', true)->where('has_edition', true)->pluck('name', 'id')->toArray();
        return view('admin.lotteryEditions.create',
            compact(
                'lotteryEdition',
                'lotteryTypes'
            )
        );
    }

    public function store(Request $request)
    {
        dd($request);
        set_time_limit(4000);
        
        $from = $request->lotteryTicketsFrom;
        $to = $request->lotteryTicketsTo;

        $lotteryEdition = LotteryEdition::where('lottery_type', $request->lottery_type)->where('number', $request->number)->first();

        if($lotteryEdition){
            $lotteryEdition->tickets_count = $lotteryEdition->tickets_count + $request->tickets_count;
            $lotteryEdition->save();
        } else {
            $lotteryEdition = LotteryEdition::create($request->except('lotteryTicketsFrom', 'lotteryTicketsTo'));
        }
        dd(1);

        if(!Schema::hasTable('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)){
            Schema::create('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number, function (Blueprint $table) {
                $table->increments('id');

                $table->string('ticket_number');

                $table->unsignedInteger('lottery_edition');
                $table->unsignedInteger('user')->nullable();
                $table->unsignedInteger('supervisor')->nullable();

                $table->boolean('active')->default(0);
                $table->boolean('return')->default(0);

                $table->timestamp('sold_date')->nullable();
                $table->timestamp('return_date')->nullable();
                $table->timestamp('created_at')->useCurrent();

                $table->foreign('lottery_edition')->references('id')->on('lottery_editions')->onDelete('cascade');
                $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('supervisor')->references('id')->on('users')->onDelete('cascade');
            });
        }

        if($from && $to){
            for($i = $from; $i < $to; $i++){
                DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->insert([
                    'ticket_number' => str_pad($i, (strlen($request->tickets_count)-1), "0", STR_PAD_LEFT),
                    'lottery_edition' => $lotteryEdition->id
                ]);
            }
        } else {
            for($i = 0; $i < $lotteryEdition->tickets_count; $i++){
                DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->insert([
                'ticket_number' => str_pad($i, (strlen($request->tickets_count)-1), "0", STR_PAD_LEFT),
                    'lottery_edition' => $lotteryEdition->id
                ]);
            }
        }       

        return redirect()->route('lotteryEditions.show', $lotteryEdition);
    }

    public function show(LotteryEdition $lotteryEdition)
    {
        return view('admin.lotteryEditions.show', compact('lotteryEdition'));
    }

    public function edit(LotteryEdition $lotteryEdition)
    {
        $lotteryTypes = LotteryType::where('active', true)->where('has_edition', true)->pluck('name', 'id')->toArray();
        return view('admin.lotteryEditions.edit', 
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
        Schema::dropIfExists('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number);
        $lotteryEdition->delete();
        return redirect()->route('lotteryEditions.index');
    }
}
