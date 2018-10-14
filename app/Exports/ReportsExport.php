<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportsExport implements FromView, ShouldAutoSize, WithEvents
{
    private $data,
        $drawLotteriesCount,
        $instantLotteriesCount,
        $drawSupervisorCount,
        $sharedTicketSupervisorCount,
        $drawsCount,
        $supervisorCount,
        $tempDrawCount,
        $tempSharedTicketCount;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('admin.exports.report', $this->data);
    }

    public function registerEvents(): array
    {
        $this->drawLotteriesCount = count($this->data['drawLotteries']);
        $this->instantLotteriesCount = count($this->data['instantLotteries']);
        $this->drawsCount = count($this->data['draws']);
        $this->supervisorCount = count($this->data['supervisors']);
        $this->drawSupervisorCount = 0;
        $this->sharedTicketSupervisorCount = 0;
        $this->tempDrawCount = 0;
        $this->tempSharedTicketCount = 0;

        return [
            AfterSheet::class    => function(AfterSheet $event) {
//                $cellRangeMain = 'A1:W1'; // Main Header
//                $event->sheet->getDelegate()->getStyle($cellRangeMain)->getFont()->setSize(12)->setBold(true);

//                if($this->drawLotteriesCount > 0){
//
//                    $cellRangeDrawLotteries = 'A3:W3'; // DrawLotteries Header
//                    $event->sheet->getDelegate()->getStyle($cellRangeDrawLotteries)->getFont()->setSize(12)->setBold(true);
//
//                    $counter = 5;
//
//                    foreach ($this->data['draws'] as $key=>$draw){
//
//                        $this->tempDrawCount++;
//
//                        if($key == 0){
//                            $drawSupervisors = 0;
//                        } else {
//                            $drawSupervisors = $this->drawSupervisorCount;
//                        }
//
//                        $range = 5+$this->drawLotteriesCount+$key*5+$drawSupervisors;
//
//                        $cellRangeLotteryDraws = 'A'.($range).':W'.($range);
//                        $event->sheet->getDelegate()->getStyle($cellRangeLotteryDraws)->getFont()->setSize(12)->setBold(true);
////                        dd($cellRangeLotteryDraws, $this->drawLotteriesCount, $this->drawSupervisorCount);
//
//                        $rangeS = 3+$this->drawLotteriesCount+5*$this->tempDrawCount+$this->drawSupervisorCount;
//
//                        $cellRangeDrawSupervisors = 'A'.($rangeS).':W'.($rangeS);
////                        dd($cellRangeDrawSupervisors);
//                        $event->sheet->getDelegate()->getStyle($cellRangeDrawSupervisors)->getFont()->setSize(12)->setBold(true);
//
//                        foreach ($this->data['supervisors'] as $supervisor){
//
//                            if($draw->hasSupervisor($supervisor->id)){
//                                $this->drawSupervisorCount++;
//                            }
//
//                        }
//
//                    }
//                }
//
//                dd($counter);
//
//                if($this->instantLotteriesCount > 0){
//
//                    $cellRangeMain2 = 'A'.($rangeS+3).':W'.($rangeS+3).''; // DrawLotteries Header
//                    $event->sheet->getDelegate()->getStyle($cellRangeMain2)->getFont()->setSize(12)->setBold(true);
//
//                    $cellRangeInstantLotteries = 'A'.($rangeS+5).':W'.($rangeS+5).'';; // DrawLotteries Header
//                    $event->sheet->getDelegate()->getStyle($cellRangeInstantLotteries)->getFont()->setSize(12)->setBold(true);
//
//                    foreach ($this->data['sharedTickets'] as $key => $sharedTicket){
//
//                        $this->tempSharedTicketCount++;
//
//                        if($key == 0){
//                            $sharedTicketSupervisors = 0;
//                        } else {
//                            $sharedTicketSupervisors = $this->sharedTicketSupervisorCount;
//                        }
//
//                        $rangeI = $rangeS+5+$this->instantLotteriesCount+2;
//
//                        $cellRangeSharedTicketSupervisors = 'A'.($rangeI).':W'.($rangeI);
//                        $event->sheet->getDelegate()->getStyle($cellRangeSharedTicketSupervisors)->getFont()->setSize(12)->setBold(true);
//
//                    }
//
//                }

            },
        ];
    }
}
