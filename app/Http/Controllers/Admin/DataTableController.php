<?php

namespace App\Http\Controllers\Admin;

use App\Models\Draw;
use App\Models\DrawLottery;
use App\Models\InstantLottery;
use App\Models\SharedTicket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class DataTableController extends Controller
{
    public function getDrawLotteries(Request $request)
    {
        $pagination = $request->pagination;
        $sort = $request->sort;

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; }
        else { $perpage = 10; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; }
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if(auth()->user()->isSupervisor()){
            if($sort){
                $resultPaginated = auth()->user()->getSupervisorDrawLotteries($sort['field'], $sort['sort'], $perpage);
            }else {
                $resultPaginated = auth()->user()->getSupervisorDrawLotteries('id', 'desc', $perpage);
            }
        } else {
            if($sort){
                $resultPaginated = DrawLottery::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
            } else {
                $resultPaginated = DrawLottery::orderBy('id', 'asc')->paginate($perpage);
            }
        }

        foreach ($resultPaginated as $row) {
            if(auth()->user()->isAdmin() || auth()->user()->isStock()){
                $row->actions = '
                    <a href="'.route('drawLottery.show', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Показать">
                        <i class="jam jam-info"></i>
                    </a>
                    <a href="'.route('drawLottery.edit', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                        <i class="jam jam-write"></i>
                    </a>
                    <a href="'.route('drawLottery.delete', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                        <i class="jam jam-trash-alt"></i>
                    </a>
                ';
            } else {
                $row->actions = '
                    <a href="'.route('drawLottery.show', $row).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Показать">
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

    public function getInstantLotteries(Request $request)
    {
        $pagination = $request->pagination;
        $sort = $request->sort;

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; }
        else { $perpage = 10; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; }
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if((auth()->user()->isAdmin()) || (auth()->user()->isStock())){
            if($sort){
                $resultPaginated = InstantLottery::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
            } else {
                $resultPaginated = InstantLottery::orderBy('id', 'asc')->paginate($perpage);
            }
        } elseif (auth()->user()->isSupervisor()) {
            if($sort){
                $resultPaginated = auth()->user()->getSupervisorInstantLotteries($sort['field'], $sort['sort'], $perpage);
            } else {
                $resultPaginated = auth()->user()->getSupervisorInstantLotteries('id', 'desc', $perpage);
            }
        }

        foreach ($resultPaginated as $row) {
            if(auth()->user()->isAdmin() || auth()->user()->isStock()) {
                $row->actions = '
                    <a href="' . route('instantLottery.show', $row) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Показать">
                        <i class="jam jam-info"></i>
                    </a>
                    <a href="' . route('instantLottery.edit', $row) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                        <i class="jam jam-write"></i>
                    </a>
                    <a href="' . route('instantLottery.delete', $row) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                        <i class="jam jam-trash-alt"></i>
                    </a>
                ';
            } else {
                $row->actions = '
                    <a href="' . route('instantLottery.show', $row) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Показать">
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

    public function getLotteryDraws(Request $request)
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
                $resultPaginated = auth()->user()->getSupervisorDraws($request->drawLottery, $sort['field'], $sort['sort'], $perpage);
            }else {
                $resultPaginated = auth()->user()->getSupervisorDraws($request->drawLottery, 'id', 'asc', $perpage);
            }
        } else {
            if($sort){
                $resultPaginated = Draw::lottery($request->drawLottery)->orderBy($sort['field'], $sort['sort'])->paginate($perpage);
            }else {
                $resultPaginated = Draw::lottery($request->drawLottery)->orderBy('id', 'asc')->paginate($perpage);
            }
        }

        foreach ($resultPaginated as $row) {
            $row->lottery_id = $row->getLottery->name;

            if(auth()->user()->isSupervisor()){
                $row->tickets_count = $row->getTotalSupervisorTickets(auth()->user()->id)->count();
            }

            if((auth()->user()->isAdmin()) || (auth()->user()->isStock())){
                $row->actions = '
                    <a href="'.route('drawLottery.draw.show', [$row->getLottery, $row]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Просмотр">
                        <i class="jam jam-info"></i>
                    </a>
                    <a href="'.route('drawLottery.draw.edit', [$row->getLottery, $row]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                        <i class="jam jam-write"></i>
                    </a>
                    <a href="'.route('drawLottery.draw.delete', [$row->getLottery, $row]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                        <i class="jam jam-trash-alt"></i>
                    </a>
                ';
            } elseif (auth()->user()->isSupervisor()) {
                $row->actions = '
                    <a href="'.route('drawLottery.draw.show', [$row->getLottery, $row]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Просмотр">
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

    public function getDrawCreatedTickets(Request $request)
    {
        $draw = Draw::find($request->draw);

        $pagination = $request->pagination;
        $sort = $request->sort;
        $query = $request->input('query');

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; }
        else { $perpage = 10; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; }
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if($query){
            if(auth()->user()->isSupervisor()){
                if(array_key_exists('generalSearch', $query)){
                    if($sort){
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('supervisor_id', auth()->user()->id)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch'].'%')
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('supervisor_id', auth()->user()->id)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch'].'%')
                            ->orderBy('ticket_number', 'asc')
                            ->paginate($perpage);
                    }
                } else {
                    if($sort){
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('supervisor_id', auth()->user()->id)
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('supervisor_id', auth()->user()->id)
                            ->orderBy('ticket_number', 'asc')
                            ->paginate($perpage);
                    }
                }
            } else {
                if(array_key_exists('generalSearch', $query)){
                    if($sort){
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch'].'%')
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch'].'%')
                            ->orderBy('ticket_number', 'asc')
                            ->paginate($perpage);
                    }
                } else {
                    if($sort){
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->orderBy('ticket_number', 'asc')
                            ->paginate($perpage);
                    }
                }
            }
        } else {
            if(auth()->user()->isSupervisor()){
                if($sort){
                    $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                        ->where('supervisor_id', auth()->user()->id)
                        ->orderBy($sort['field'], $sort['sort'])
                        ->paginate($perpage);
                } else {
                    $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                        ->where('supervisor_id', auth()->user()->id)
                        ->orderBy('ticket_number', 'asc')
                        ->paginate($perpage);
                }
            } else {
                if($sort){
                    $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                        ->orderBy($sort['field'], $sort['sort'])
                        ->paginate($perpage);
                } else {
                    $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                        ->orderBy('ticket_number', 'asc')
                        ->paginate($perpage);
                }
            }
        }

        foreach ($resultPaginated as $row) {

            $seller = User::where('id',$row->seller_id)->first();
            if(!empty($seller)){
                $row->seller_id = $seller->getFullName();
            } else {
                $row->seller_id = '-';
            }

            $supervisor = User::where('id',$row->supervisor_id)->first();
            if(!empty($supervisor)){
                $row->supervisor_id = $supervisor->getFullName();
            } else {
                $row->supervisor_id = '-';
            }

            $row->actions = '
                <a href="'.route('drawLottery.draw.ticket.show', [$draw->getLottery, $draw, $row->id]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Просмотр">
                    <i class="jam jam-info"></i>
                </a>
                <a href="'.route('drawLottery.draw.ticket.edit', [$draw->getLottery, $draw, $row->id]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                    <i class="jam jam-write"></i>
                </a>
                <a href="'.route('drawLottery.draw.ticket.delete',[$draw->getLottery, $draw, $row->id]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                    <i class="jam jam-trash-alt"></i>
                </a>
            ';
        }

        if(array_key_exists('pages', $pagination)) {
            $pages = $pagination['pages'];
        } else {
            $pages = $resultPaginated->lastPage();
        }

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

    public function getDrawReturnedTickets(Request $request)
    {
        $draw = Draw::find($request->draw);
        $status = 4; // 4 - for returned tickets

        $pagination = $request->pagination;
        $sort = $request->sort;
        $query = $request->input('query');

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; }
        else { $perpage = 10; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; }
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if($query){
            if(auth()->user()->isSupervisor()){
                if(array_key_exists('generalSearch2', $query)){
                    if($sort){
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('status', $status)
                            ->where('supervisor_id', auth()->user()->id)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch2'].'%')
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('status', $status)
                            ->where('supervisor_id', auth()->user()->id)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch2'].'%')
                            ->orderBy('ticket_number', 'asc')
                            ->paginate($perpage);
                    }
                } else {
                    if($sort){
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('status', $status)
                            ->where('supervisor_id', auth()->user()->id)
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('status', $status)
                            ->where('supervisor_id', auth()->user()->id)
                            ->orderBy('ticket_number', 'asc')
                            ->paginate($perpage);
                    }
                }
            } else {
                if(array_key_exists('generalSearch2', $query)){
                    if($sort){
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('status', $status)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch2'].'%')
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('status', $status)
                            ->where('ticket_number', 'like', '%'.$query['generalSearch2'].'%')
                            ->orderBy('ticket_number', 'asc')
                            ->paginate($perpage);
                    }
                } else {
                    if($sort){
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('status', $status)
                            ->orderBy($sort['field'], $sort['sort'])
                            ->paginate($perpage);
                    } else {
                        $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                            ->where('status', $status)
                            ->orderBy('ticket_number', 'asc')
                            ->paginate($perpage);
                    }
                }
            }
        } else {
            if(auth()->user()->isSupervisor()){
                if($sort){
                    $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                        ->where('status', $status)
                        ->where('supervisor_id', auth()->user()->id)
                        ->orderBy($sort['field'], $sort['sort'])
                        ->paginate($perpage);
                } else {
                    $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                        ->where('status', $status)
                        ->where('supervisor_id', auth()->user()->id)
                        ->orderBy('ticket_number', 'asc')
                        ->paginate($perpage);
                }
            } else {
                if($sort){
                    $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                        ->where('status', $status)
                        ->orderBy($sort['field'], $sort['sort'])
                        ->paginate($perpage);
                } else {
                    $resultPaginated = DB::table($draw->getLottery->getNameSlugged().'_'.$draw->draw_number)
                        ->where('status', $status)
                        ->orderBy('ticket_number', 'asc')
                        ->paginate($perpage);
                }
            }
        }

        foreach ($resultPaginated as $row) {

            if($row->returned_at){
                $row->returned_at = date("d.m.Y H:i", strtotime($row->returned_at));
            } else {
                $row->returned_at = '-';
            }
            $seller = User::where('id',$row->seller_id)->first();
            if(!empty($seller)){
                $row->seller_id = $seller->getFullName();
            } else {
                $row->seller_id = '-';
            }
            $supervisor = User::where('id',$row->supervisor_id)->first();
            if(!empty($supervisor)){
                $row->supervisor_id = $supervisor->getFullName();
            } else {
                $row->supervisor_id = '-';
            }
            $row->actions = '
                <a href="'.route('drawLottery.draw.ticket.show', [$draw->getLottery, $draw, $row->id]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Просмотр">
                    <i class="jam jam-info"></i>
                </a>
                <a href="'.route('drawLottery.draw.ticket.edit', [$draw->getLottery, $draw, $row->id]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                    <i class="jam jam-write"></i>
                </a>
                <a href="'.route('drawLottery.draw.ticket.delete',[$draw->getLottery, $draw, $row->id]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                    <i class="jam jam-trash-alt"></i>
                </a>
            ';
        }

        if(array_key_exists('pages', $pagination)) {
            $pages = $pagination['pages'];
        } else {
            $pages = $resultPaginated->lastPage();
        }

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

    public function getInstantLotterySharedTickets(Request $request)
    {
        $lottery = InstantLottery::find($request->lottery);

        $pagination = $request->pagination;
        $sort = $request->sort;

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; }
        else { $perpage = 10; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; }
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if(auth()->user()->isAdmin() || auth()->user()->isStock()){

            if($sort){
                $resultPaginated = SharedTicket::orderBy($sort['field'], $sort['sort'])->paginate($perpage);
            } else {
                $resultPaginated = SharedTicket::orderBy('id', 'asc')->paginate($perpage);
            }

        } elseif(auth()->user()->isSupervisor()){

            if($sort){
                $resultPaginated = SharedTicket::where('supervisor_id', auth()->user()->id)->orderBy($sort['field'], $sort['sort'])->paginate($perpage);
            } else {
                $resultPaginated = SharedTicket::where('supervisor_id', auth()->user()->id)->orderBy('id', 'asc')->paginate($perpage);
            }

        }

        foreach ($resultPaginated as $row) {
            $seller = User::where('id',$row->seller_id)->first();
            if(!empty($seller)){
                $row->seller_id = $seller->getFullName();
            } else {
                $row->seller_id = '-';
            }
            $supervisor = User::where('id',$row->supervisor_id)->first();
            if(!empty($supervisor)){
                $row->supervisor_id = $supervisor->getFullName();
            } else {
                $row->supervisor_id = '-';
            }
            $row->owner_id = $row->getOwner->getFullName();

            $row->shared_at = $row->getCreatedDate().' '.$row->getCreatedTime();
            if(auth()->user()->isAdmin() || auth()->user()->isStock()){
                $row->actions = '
                    <a href="'.route('instantLottery.sharedTicket.show', [$lottery, $row]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                        <i class="jam jam-info"></i>
                    </a>
                    <a href="'.route('instantLottery.sharedTicket.edit', [$lottery, $row]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                        <i class="jam jam-write"></i>
                    </a>
                    <a href="'.route('instantLottery.sharedTicket.delete',[$lottery, $row]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                        <i class="jam jam-trash-alt"></i>
                    </a>
                ';
            } else {
                $row->actions = '
                    <a href="'.route('instantLottery.sharedTicket.show', [$lottery, $row]).'" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                        <i class="jam jam-info"></i>
                    </a>
                ';
            }

        }

        if(array_key_exists('pages', $pagination)) {
            $pages = $pagination['pages'];
        } else {
            $pages = $resultPaginated->lastPage();
        }

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
}