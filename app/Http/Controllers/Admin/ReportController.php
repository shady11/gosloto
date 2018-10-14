<?php

namespace App\Http\Controllers\Admin;

use App\Models\Draw;
use App\Models\DrawLottery;
use App\Models\InstantLottery;
use App\Models\Report;
use App\Models\SharedTicket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;

class ReportController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        $report = new Report;

        $users = User::where('type', 2)->pluck('name', 'id')->toArray();
        $supervisors = User::where('type', 3)->pluck('name', 'id')->toArray();

        return view('admin.reports.create',
            compact(
                'report',
                'users',
                'supervisors'
            )
        );
    }

    public function store(Request $request)
    {
//        dd($request);

        $drawLotteryIds = $request->drawLotteries;
        $instantLotteryIds = $request->instantLotteries;
        $drawIds = $request->draws;
        $supervisorIds = $request->supervisors;
        $sellerIds = $request->sellers;

        $drawLotteries = collect();
        $instantLotteries = collect();
        $sharedTickets = collect();
        $draws = collect();
        $supervisors = collect();
        $sellers = collect();

        if($drawLotteryIds){
            foreach ($drawLotteryIds as $drawLotteryId) {
                $drawLotteries = $drawLotteries->push(DrawLottery::find($drawLotteryId));
            }
        }

        if($instantLotteryIds){
            foreach ($instantLotteryIds as $instantLotteryId) {
                $instantLotteries = $instantLotteries->push(InstantLottery::find($instantLotteryId));

//                dd(InstantLottery::find($instantLotteryId)->getSharedTickets);
                foreach (InstantLottery::find($instantLotteryId)->getSharedTickets as $sharedTicket){
                    $sharedTickets = $sharedTickets->push($sharedTicket);
                }
            }
        }

        if($drawIds){
            foreach ($drawIds as $drawId) {
                $draws = $draws->push(Draw::find($drawId));
            }
        }

        if($supervisorIds){
            foreach ($supervisorIds as $supervisorId) {
                $supervisors = $supervisors->push(User::find($supervisorId));
            }
        }

        if($sellerIds){
            foreach ($sellerIds as $sellerId) {
                $sellers = $sellers->push(User::find($sellerId));
            }
        }

        $data = compact('drawLotteries', 'instantLotteries', 'sharedTickets', 'draws', 'supervisors', 'sellers');
//        dd($data);

//        return view('admin.exports.report', $data);

        return Excel::download(new ReportsExport($data), 'отчет_'.date("d_m_Y").'.xlsx');
    }

    public function show(Report $report)
    {
        //
    }

    public function edit(Report $report)
    {
        //
    }

    public function update(Request $request, Report $report)
    {
        //
    }

    public function destroy(Report $report)
    {
        //
    }

    public function reportGetDrawLotteries(Request $request)
    {
        $lotteries = DrawLottery::all();
        $onChange = 'onchange="getDraws(this)"';

        $result = '<select id="drawLotterySelect" '.$onChange.' class="form-control m-bootstrap-select m_selectpicker" title="-- выбрать --" multiple data-actions-box="true" data-select-all-text="Выбрать все" data-deselect-all-text="Отменить" name="drawLotteries[]">';

        foreach ($lotteries as $lottery){
            $result .= '<option value="'.$lottery->id.'">'.$lottery->name.'</option>';
        }

        $result .= '</select>';

        return $result;

    }

    public function reportGetInstantLotteries()
    {
        $lotteries = InstantLottery::all();

        $result = '<select id="instantLotterySelect" class="form-control m-bootstrap-select m_selectpicker" title="-- выбрать --" multiple data-actions-box="true" data-select-all-text="Выбрать все" data-deselect-all-text="Отменить" name="instantLotteries[]">';

        foreach ($lotteries as $lottery){
            $result .= '<option value="'.$lottery->id.'">'.$lottery->name.'</option>';
        }

        $result .= '</select>';

        return $result;
    }

    public function reportGetDraws(Request $request)
    {
        $ids = $request->ids;
        $draws = collect();

        if($ids){
            foreach ($ids as $id){
                $draws = $draws->merge(Draw::where('lottery_id', $id)->get());
            }

            $result = '<select class="form-control m-bootstrap-select m_selectpicker" title="-- выбрать --" multiple data-actions-box="true" data-select-all-text="Выбрать все" data-deselect-all-text="Отменить" name="draws[]">';

            foreach ($draws as $draw){
                $result .= '<option value="'.$draw->id.'">'.$draw->getLottery->name.' №'.$draw->draw_number.'</option>';
            }

            $result .= '</select>';
        } else {
            $result = '<select class="form-control m-bootstrap-select m_selectpicker" title="-- выбрать --" name="draws[]"></select>';
        }

        return $result;
    }
}