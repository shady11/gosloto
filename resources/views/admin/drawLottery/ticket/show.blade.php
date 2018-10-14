@extends('admin.layouts.default')

@section('title', 'Билет тиража')

@section('content')

    @include('admin.subheader.lottery')

    <div class="m-content">

        <input type="hidden" id="draw" value="{{$draw->id}}">

        <div class="m-portlet m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{$drawLottery->name}} - Тираж №{{$draw->draw_number}} - Билет №{{$ticket->ticket_number}}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-widget13">
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Номер билета
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            {{$ticket->ticket_number}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Лотерея
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            {{$drawLottery->name}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Номер тиража
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            {{$draw->draw_number}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Супервайзер
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            {{$supervisor}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Реализатор
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder">
                            {{$seller}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Создал
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder">
                            {{$owner}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Дата создания
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder">
                            {{date("d.m.Y H:i", strtotime($ticket->created_at))}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Дата выдачи супервайзеру
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder">
                            {{$ticket->shared_to_supervisor_at}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Дата выдачи реализатору
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder">
                            {{$ticket->shared_to_seller_at}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Дата продажи
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder">
                            {{$ticket->sold_at}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Дата возврата
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder">
                            {{$ticket->returned_at}}
                        </span>
                    </div>

                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Статус
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            @if($ticket->status == 4)
                                <span class="m-badge m-badge--danger m-badge--wide">возврат</span>
                            @elseif($ticket->status == 3)
                                <span class="m-badge m-badge--success m-badge--wide">продан</span>
                            @elseif($ticket->status == 2 || $ticket->status == 1)
                                <span class="m-badge m-badge--info m-badge--wide">выдан</span>
                            @else
                                <span class="m-badge m-badge--metal m-badge--wide">неактивный</span>
                            @endif
                        </span>
                    </div>
                    <div class="m-widget13__action m--align-right">
                        <a href="{{route('drawLottery.draw.show', [$drawLottery, $draw])}}" class="m-widget__detalis btn btn-secondary">
                            Назад
                        </a>
                        @if((auth()->user()->isAdmin()) || (auth()->user()->isStock()))
                            <a href="{{route('drawLottery.draw.ticket.edit', [$drawLottery, $draw, $ticket->id])}}" class="m-widget__detalis btn btn-info">
                                Редактировать
                            </a>
                            <a href="{{route('drawLottery.draw.ticket.delete', [$drawLottery, $draw, $ticket->id])}}" class="btn btn-danger">
                                Удалить
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
@endsection