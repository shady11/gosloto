<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DrawExport;
use App\Models\Draw;
use App\Models\DrawLottery;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Maatwebsite\Excel\Facades\Excel;

class DrawController extends Controller
{
    public function index() {}

    public function create(DrawLottery $drawLottery)
    {
        $draw = new Draw();
        return view('admin.drawLottery.draw.create',
            compact(
                'draw',
                'drawLottery'
            )
        );
    }

    public function store(Request $request, DrawLottery $drawLottery)
    {
        set_time_limit(4000);

        $length = $request->length;

        $draw = Draw::where('lottery_id', $drawLottery->id)->where('draw_number', $request->draw_number)->first();

        if($draw){
            return redirect()->back()->withErrors(['draw', true]);
        } else {
            $draw = Draw::create($request->except('ticketsFrom', 'ticketsTo'));

            if(!Schema::hasTable($drawLottery->getNameSlugged().'_'.$request->draw_number.'_tickets')){
                Schema::create($drawLottery->getNameSlugged().'_'.$request->draw_number, function (Blueprint $table) {
                    $table->increments('id');

                    $table->string('ticket_number');

                    $table->integer('status')->nullable();

                    $table->unsignedInteger('draw_id')->nullable();
                    $table->unsignedInteger('lottery_id')->nullable();
                    $table->unsignedInteger('seller_id')->nullable();
                    $table->unsignedInteger('supervisor_id')->nullable();
                    $table->unsignedInteger('owner_id')->nullable();

                    $table->timestamp('shared_to_seller_at')->nullable();
                    $table->timestamp('shared_to_supervisor_at')->nullable();
                    $table->timestamp('sold_at')->nullable();
                    $table->timestamp('returned_at')->nullable();
                    $table->timestamp('created_at')->useCurrent();

                    $table->foreign('draw_id')->references('id')->on('draws')->onDelete('cascade');
                    $table->foreign('lottery_id')->references('id')->on('draw_lotteries')->onDelete('cascade');
                    $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
                    $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('cascade');
                    $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
                });
            }

            if($request->ticketsFrom && $request->ticketsTo){
                $from = $request->ticketsFrom;
                $to = $request->ticketsTo;
            } else {
                $from = 0;
                $to = $request->tickets_count;
            }

            for($i = $from; $i <= $to; $i++){
                DB::table($drawLottery->getNameSlugged().'_'.$request->draw_number)->insert([
                    'ticket_number' => str_pad($i, $length, "0", STR_PAD_LEFT),
                    'status' => 0,
                    'draw_id' => $draw->id,
                    'lottery_id' => $drawLottery->id,
                    'owner_id' => auth()->user()->id
                ]);
            }
        }

        return redirect()->route('drawLottery.draw.show', [$drawLottery, $draw]);
    }

    public function show(DrawLottery $drawLottery, Draw $draw)
    {
        return view('admin.drawLottery.draw.show',
            compact(
                'drawLottery',
                'draw'
            )
        );
    }

    public function edit(DrawLottery $drawLottery, Draw $draw)
    {
        return view('admin.drawLottery.draw.edit',
            compact(
                'drawLottery',
                'draw'
            )
        );
    }

    public function update(Request $request, DrawLottery $drawLottery, Draw $draw)
    {
        $draw->update($request->all());
        return redirect()->route('drawLottery.draw.show', [$drawLottery, $draw]);
    }

    public function destroy(DrawLottery $drawLottery, Draw $draw)
    {
        Schema::dropIfExists($drawLottery->getNameSlugged().'_'.$draw->draw_number);
        $draw->delete();
        return redirect()->route('drawLottery.show', $drawLottery);
    }

    public function report(DrawLottery $drawLottery, Draw $draw)
    {
        $tickets = DB::table($drawLottery->getNameSlugged().'_'.$draw->draw_number)->get();
        $supervisors = User::where('type', 3)->get();

        $data = compact('drawLottery', 'draw', 'tickets', 'supervisors');

        return view('admin.exports.draw', $data);

        return Excel::download(new DrawExport($data), $drawLottery->getNameSlugged().'_'.$draw->draw_number.'_'.date("d_m_Y").'.xlsx');
    }
}
