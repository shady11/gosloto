<?php

namespace App\Http\Controllers\Admin;

use App\Models\LotteryEdition;
use App\Models\Report;
use App\Models\LotteryType;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;

use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;

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

        $lottery_type_ids = $request->lottery_types;
        $lottery_editions_ids = $request->lottery_editions;
        $supervisor_ids = $request->supervisors;
        $user_ids = $request->users;

        $lottery_types = collect();
        $lottery_editions = collect();
        $supervisors = collect();

        if($lottery_type_ids){
            foreach ($lottery_type_ids as $lottery_type_id) {
                $lottery_types = $lottery_types->push(LotteryType::find($lottery_type_id));
            }
        } else {
            $lottery_types = LotteryType::all();
        }

        if($supervisor_ids){
            foreach ($supervisor_ids as $supervisor_id) {
                $supervisors = $supervisors->push(User::find($supervisor_id));
            }
        } else {
            $supervisors = User::where('type', '3')->get();
        }

        if($request->has_edition){

            if($lottery_editions_ids){
                foreach ($lottery_editions_ids as $lottery_editions_id) {
                    $lottery_editions = $lottery_editions->push(LotteryEdition::find($lottery_editions_id));
                }
            } else {
                $lottery_editions = LotteryEdition::all();
            }

        } else {

//            $lottery_types

        }

        $data = compact('lottery_types', 'lottery_editions', 'supervisors');

//        $dir  = 'assets/reports/';
//        $storage = \Storage::disk('public');
//        $storage->makeDirectory($dir);
//
////        return view('admin.reports.pdf');
//        $pdf = PDF::loadView('admin.reports.pdf', compact('lottery_types', 'lottery_editions', 'supervisors'));
//        return $pdf->stream('invoice.pdf');

//        return view('admin.exports.report', compact('lottery_types', 'lottery_editions', 'supervisors'));

        return Excel::download(new ReportsExport($data), 'users.xlsx');
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

    public function GetPdf(Request $request)
    {
//        dd($request);
//        $dir  = 'assets/reports/';
//        $storage = \Storage::disk('public');
//        $storage->makeDirectory($dir);
//
////        return view('admin.reports.pdf');
//        $pdf = PDF::loadView('admin.reports.pdf', $request);
//        return $pdf->stream('invoice.pdf');

        $data = User::all();

        return Excel::download(new UsersExport($data), 'users.xlsx');

    }

    public function reportGetLotteryTypes(Request $request)
    {
        $has_edition = $request->has_edition;
        if($has_edition){
            $lotteryTypes = LotteryType::where('has_edition', true)->get();
            $onChange = 'onchange="getLotteryEditions(this)"';
        } else {
            $lotteryTypes = LotteryType::where('has_edition', false)->get();
            $onChange = '';
        }

        $result = '<select id="lotteryTypeSelect" '.$onChange.' class="form-control m-bootstrap-select m_selectpicker" title="-- выбрать --" multiple data-actions-box="true" data-select-all-text="Выбрать все" data-deselect-all-text="Отменить" name="lottery_types[]">';

        foreach ($lotteryTypes as $lotteryType){
            $result .= '<option value="'.$lotteryType->id.'">'.$lotteryType->name.'</option>';
        }

        $result .= '</select>';

        return $result;
    }

    public function reportGetLotteryEditions(Request $request)
    {
        $ids = $request->ids;
        $lotteryEditions = collect();

        if($ids){
            foreach ($ids as $id){
                $lotteryEditions = $lotteryEditions->merge(LotteryEdition::where('lottery_type', $id)->get());
            }

            $result = '<select class="form-control m-bootstrap-select m_selectpicker" title="-- выбрать --" multiple data-actions-box="true" data-select-all-text="Выбрать все" data-deselect-all-text="Отменить" name="lottery_editions[]">';

            foreach ($lotteryEditions as $lotteryEdition){
                $result .= '<option value="'.$lotteryEdition->id.'">'.$lotteryEdition->getLotteryType()->name.' №'.$lotteryEdition->number.'</option>';
            }

            $result .= '</select>';
        } else {
            $result = '<select class="form-control m-bootstrap-select m_selectpicker" title="-- выбрать --" name="lottery_editons[]"></select>';
        }

        return $result;
    }
}