<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DrawLotteryExport;
use App\Models\Draw;
use App\Models\DrawLottery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class DrawLotteryController extends Controller
{
    public function index() {}

    public function create()
    {
        $drawLottery = new DrawLottery();
        return view('admin.drawLottery.create',
            compact(
                'drawLottery'
            )
        );
    }

    public function store(Request $request)
    {
        $drawLottery = DrawLottery::create($request->all());
        return redirect()->route('drawLottery.show', $drawLottery);
    }

    public function show(DrawLottery $drawLottery)
    {
        return view('admin.drawLottery.show',
            compact(
                'drawLottery'
            )
        );
    }

    public function edit(DrawLottery $drawLottery)
    {
        return view('admin.drawLottery.edit',
            compact(
                'drawLottery'
            )
        );
    }

    public function update(Request $request, DrawLottery $drawLottery)
    {
        $drawLottery->update($request->all());
        return redirect()->route('drawLottery.show', $drawLottery);
    }

    public function destroy(DrawLottery $drawLottery)
    {
        foreach ($drawLottery->getDraws as $draw){
            Schema::dropIfExists($drawLottery->getNameSlugged().'_'.$draw->draw_number);
            $draw->delete();
        }
        $drawLottery->delete();
        return redirect()->route('lottery.index');
    }

    public function reportAll()
    {
        $drawLotteries = DrawLottery::all();

        $data = compact('drawLotteries');

//        return view('admin.exports.drawLotteries', $data);

        return Excel::download(new DrawLotteryExport($data), 'тиражные_лотереи_'.date("d_m_Y").'.xlsx');
    }
}
