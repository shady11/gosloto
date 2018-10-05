<?php

namespace App\Http\Controllers\Admin;

use App\Models\LotteryType;
use App\Models\LotteryEdition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Pagination\Paginator;

class LotteryTypeEditionController extends Controller
{
    public function index() {}

    public function create(LotteryType $lotteryType)
    {
        $lotteryEdition = new LotteryEdition;
        $lotteryTypes = LotteryType::where('active', true)->where('has_edition', true)->pluck('name', 'id')->toArray();
        return view('admin.lotteryEditions.create',
            compact(
                'lotteryEdition',
                'lotteryTypes',
                'lotteryType'
            )
        );
    }

    public function store(Request $request, LotteryType $lotteryType)
    {
//        dd($request, $lotteryType);
        set_time_limit(4000);

        $from = $request->lotteryTicketsFrom;
        $to = $request->lotteryTicketsTo;

        $lotteryEdition = LotteryEdition::where('lottery_type', $lotteryType->id)->where('number', $request->number)->first();

        if($lotteryEdition){
            $lotteryEdition->tickets_count = $lotteryEdition->tickets_count + $request->tickets_count;
            $lotteryEdition->save();
        } else {
            $lotteryEdition = LotteryEdition::create([
                'number' => $request->number,
                'lottery_type' => $lotteryType->id,
                'tickets_count' => $request->tickets_count,
                'active' => $request->active
            ]);
        }

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
                    'ticket_number' => str_pad($i, (strlen($to)), "0", STR_PAD_LEFT),
                    'lottery_edition' => $lotteryEdition->id
                ]);
            }
        } else {
            for($i = 0; $i < $lotteryEdition->tickets_count; $i++){
                DB::table('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number)->insert([
                    'ticket_number' => str_pad($i, (strlen($to)), "0", STR_PAD_LEFT),
                    'lottery_edition' => $lotteryEdition->id
                ]);
            }
        }

        return redirect()->route('lottery.lotteryEdition.show', [$lotteryType, $lotteryEdition]);
    }

    public function show(LotteryType $lotteryType, LotteryEdition $lotteryEdition)
    {
        return view('admin.lotteryEditions.show',
            compact(
                'lotteryEdition',
                'lotteryType'
            )
        );
    }

    public function edit(LotteryType $lotteryType, $id)
    {
        $lotteryEdition = LotteryEdition::find($id);
        return view('admin.lotteryEditions.edit',
            compact(
                'lotteryEdition',
                'lotteryType'
            )
        );
    }

    public function update(Request $request, LotteryType $lotteryType, LotteryEdition $lotteryEdition)
    {
        $lotteryEdition->update($request->all());
        return redirect()->route('lottery.lotteryEdition.show', [$lotteryType, $lotteryEdition]);
    }

    public function destroy(LotteryType $lotteryType, LotteryEdition $lotteryEdition)
    {
        Schema::dropIfExists('lottery_edition_'.$lotteryEdition->lottery_type.'_'.$lotteryEdition->number);
        $lotteryEdition->delete();
        return redirect()->route('lotteryTypes.show', $lotteryType);
    }
}
