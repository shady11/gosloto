@extends('admin.layouts.default')

@section('title', 'Выданные билеты')

@section('content')

    @include('admin.lotteries.subheader')

    <div class="m-content">
        <div class="m-portlet m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Выданные билеты
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="{{route('instantLottery.sharedTicket.ticketsSold', [$instantLottery, $sharedTicket])}}" class="btn btn-success m--margin-left-10">
                        Добавить проданные
                    </a>
                    <a href="{{route('instantLottery.sharedTicket.ticketsReturned', [$instantLottery, $sharedTicket])}}" class="btn btn-success m--margin-left-10">
                        Добавить возврат
                    </a>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-widget13">
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Название
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            {{$instantLottery->name}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Супервайзер:
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            @if($sharedTicket->getSupervisor) {{$sharedTicket->getSupervisor->getFullName()}} @else - @endif
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Реализатор:
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            @if($sharedTicket->getSeller) {{$sharedTicket->getSeller->getFullName()}} @else - @endif
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Количество выданных билетов:
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            {{$sharedTicket->tickets_count}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Дата выдачи супервайзеру:
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            {{$sharedTicket->shared_to_supervisor_at}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Дата выдачи реализатору:
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            {{$sharedTicket->shared_to_seller_at}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Выдал:
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            {{$sharedTicket->getOwner->getFullName()}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Количество проданных билетов:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder">
                            {{$sharedTicket->sold_tickets_count}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Дата продажи:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder">
                            {{$sharedTicket->sold_at}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Количество утилизированных билетов:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder">
                            {{$sharedTicket->returned_tickets_count}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Дата возврата:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder">
                            {{$sharedTicket->returned_at}}
                        </span>
                    </div>

                    <div class="m-widget13__action m--align-right">
                        <a href="{{route('instantLottery.show', $instantLottery)}}" class="m-widget__detalis btn btn-secondary">
                            Назад
                        </a>
                        @if((auth()->user()->isAdmin()) || (auth()->user()->isStock()))
                            <a href="{{route('instantLottery.sharedTicket.edit', [$instantLottery, $sharedTicket])}}" class="m-widget__detalis btn btn-info">
                                Редактировать
                            </a>
                            <a href="{{route('instantLottery.sharedTicket.delete', [$instantLottery, $sharedTicket])}}" class="btn btn-danger">
                                Удалить
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

