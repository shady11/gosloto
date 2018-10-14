<?php

namespace App\Http\Controllers\Admin;

use App\Exports\InstantLotteryExport;
use App\Models\InstantLottery;
use App\Models\Lottery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class InstantLotteryController extends Controller
{
    public function index() {}

    public function create()
    {
        $instantLottery = new InstantLottery();

        return view('admin.instantLottery.create',
            compact(
                'instantLottery'
            )
        );
    }

    public function store(Request $request)
    {
        $instantLottery = InstantLottery::create($request->all());

        return redirect()->route('instantLottery.show', $instantLottery);
    }

    public function show(InstantLottery $instantLottery)
    {
        return view('admin.instantLottery.show', compact('instantLottery'));
    }

    public function edit(InstantLottery $instantLottery)
    {
        return view('admin.instantLottery.edit',
            compact(
                'instantLottery'
            )
        );
    }

    public function update(Request $request, InstantLottery $instantLottery)
    {
        $instantLottery->update($request->all());
        return redirect()->route('instantLottery.show', $instantLottery);
    }

    public function destroy(InstantLottery $instantLottery)
    {
        $instantLottery->delete();
        return redirect()->route('lottery.index');
    }

    public function reportAll()
    {
        $lotteries = InstantLottery::all();

        $data = compact('lotteries');

//        return view('admin.exports.instantLotteries', $data);

        return Excel::download(new InstantLotteryExport($data), 'моментальные_лотереи_'.date("d_m_Y").'.xlsx');
    }
}
