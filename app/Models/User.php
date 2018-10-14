<?php

namespace App\Models;

use App\Models\Lottery;
use App\Models\LotteryEdition;
use App\Models\SharedTicket;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Nicolaslopezj\Searchable\SearchableTrait;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, LogsActivity, HasApiTokens, SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'users';

    protected $hidden = ['password', 'remember_token'];

    protected $guarded = ['id'];

    protected $searchable = [
        'columns' => [
            'name' => 10,
            'lastname' => 10,
            'login' => 10,
            'email' => 10
        ],
    ];

    public function getFullName()
    {
        return $this->name.' '.$this->lastname;
    }
    public function getUserType()
    {
        return $this->belongsTo('App\Models\UserType', 'type')->first();
    }
    public function getStatus()
    {
        if($this->active){
            $class = 'success';
            $status = 'активный';
        } else {
            $class = 'metal';
            $status = 'неактивный';
        }
        return '<span class="m-badge m-badge--'.$class.' m-badge--wide">'.$status.'</span>';
    }

    public function getLotteriesWithEdition()
    {
        $editionsResult = array();
        $editions = LotteryEdition::where('active', true)->get();
        foreach ($editions as $key => $row) {
            $hasLotteriesWithEditions = DB::table('lottery_edition_'.$row->lottery_type.'_'.$row->number)->where('user', $this->id)->get();
            $row->user_tickets_count = count($hasLotteriesWithEditions);
            if($hasLotteriesWithEditions->isNotEmpty()){

            }
        }
        return $editionsResult;
    }

    public function getSupervisorLotteriesWithEdition($sortField, $sortOrder, $perPage)
    {
        $editionsResult = array();
        $editions = LotteryEdition::where('active', true)->orderBy($sortField, $sortOrder)->get();
        foreach ($editions as $key => $row) {
            $hasLotteriesWithEditions = DB::table('lottery_edition_'.$row->lottery_type.'_'.$row->number)->where('supervisor', $this->id)->get();
            if($hasLotteriesWithEditions->isNotEmpty()){
                $editionsResult[] = $row;
            }
        }
        return $this->customPaginate($editionsResult, $perPage);
    }

    public function getLotteries()
    {
        $lotteriesResult = array();
        $lotteries = Lottery::where('active', true)->get();
        foreach ($lotteries as $key => $row) {
            $sharedTickets = SharedTicket::where('user', $this->id)->where('lottery', $row->id)->first();
            if($sharedTickets){
                $lotteriesResult[] =$row;
            }
        }
        return $lotteriesResult;
    }

//    Lotteries
    public function getInstantLotteries(){
        $lotteriesResult = collect();
        $lotteries = InstantLottery::all();
        foreach ($lotteries as $key => $row) {
            $sharedTickets = SharedTicket::where('supervisor_id', $this->id)->where('lottery_id', $row->id)->whereNotNull('shared_to_supervisor_at')->first();
            if($sharedTickets){
                $lotteriesResult = $lotteriesResult->merge($row);
            }
        }
        return $lotteriesResult;
    }

    public function getSupervisorInstantLotteries($sortField, $sortOrder, $perPage)
    {
        $lotteriesResult = array();
        $lotteries = InstantLottery::orderBy($sortField, $sortOrder)->get();
        foreach ($lotteries as $key => $row) {
            $sharedTickets = SharedTicket::where('supervisor_id', $this->id)->where('lottery_id', $row->id)->whereNotNull('shared_to_supervisor_at')->first();
            if($sharedTickets){
                $lotteriesResult[] = $row;
            }
        }
        return $this->customPaginate($lotteriesResult, $perPage);
    }

    public function getSupervisorDrawLotteries($sortField, $sortOrder, $perPage)
    {
        $lotteriesResult = $drawsResult = array();
        $lotteries = DrawLottery::orderBy($sortField, $sortOrder)->get();
        foreach ($lotteries as $key => $row){
            $draws = Draw::where('lottery_id', $row->id)->get();
            foreach ($draws as $draw){
                $drawTickets = DB::table($row->getNameSlugged().'_'.$draw->draw_number)->where('supervisor_id', $this->id)->get();
                if($drawTickets->isNotEmpty()){
                    $drawsResult[] = $draw;
                }
            }
            if($drawsResult){
                $lotteriesResult[] = $row;
            }
        }
        return $this->customPaginate($lotteriesResult, $perPage);
    }

    public function getSupervisorDraws($drawLottery, $sortField, $sortOrder, $perPage)
    {
        $drawsResult = array();
        $draws = Draw::where('lottery_id', $drawLottery)->get();
        foreach ($draws as $draw){
            $drawTickets = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)->where('supervisor_id', $this->id)->get();
            if($drawTickets->isNotEmpty()){
                $drawsResult[] = $draw;
            }
        }
        return $this->customPaginate($drawsResult, $perPage);
    }

//    Tickets
    public function getTotalDrawTickets($draw){
        return DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)->where('supervisor_id', $this->id)->orderBy('ticket_number', 'asc')->get();
    }
    public function getSoldDrawTickets($draw){
        return DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)->
            where('supervisor_id', $this->id)->
            where('status', 3)->
            orderBy('ticket_number', 'asc')->
            get();
    }
    public function getReturnedDrawTickets($draw){
        return DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)->
            where('supervisor_id', $this->id)->
            where('status', 4)->
            orderBy('ticket_number', 'asc')->
            get();
    }

//    User Types
    public function isAdmin()
    {
        return $this->getUserType()->slug == 'admin';
    }
    public function isStock()
    {
        return $this->getUserType()->slug == 'stock';
    }
    public function isSupervisor()
    {
        return $this->getUserType()->slug == 'supervisor';
    }

    // Helpers
    public static function customPaginate($items, $perPage)
    {
        //Get current page form url e.g. &page=6
        $currentPage = Paginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($items);

        //Define how many items we want to be visible in each page
        $perPage = $perPage;

        //Slice the collection to get the items to display in current page
        if($currentPage){
            $currentPageSearchResults = $collection->slice(($currentPage-1) * $perPage, $perPage)->all();
        } else {
            $currentPageSearchResults = $collection->slice(0 * $perPage, $perPage)->all();
        }


        //Create our paginator and pass it to the view
        $paginatedSearchResults = new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

        return $paginatedSearchResults;
    }
}
