@extends('admin.layouts.default')

@section('title', 'Тираж лотереи')

@section('content')

    @include('admin.subheader.lottery')

    <div class="m-content">

        <input type="hidden" id="draw" value="{{$draw->id}}">

        <div class="m-portlet m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{$drawLottery->name}} Тираж №{{$draw->draw_number}}
                        </h3>
                    </div>
                </div>
                @if((auth()->user()->isAdmin()) || (auth()->user()->isStock()))
                    <div class="m-portlet__head-tools">
                        <a href="{{route('drawLottery.draw.report', [$drawLottery, $draw])}}" class="btn btn-default m--margin-left-10">
                            Отчет
                        </a>
                    </div>
                @endif
            </div>
            <div class="m-portlet__body">
                <div class="m-widget13">
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
                            Общее количество билетов
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            @if((auth()->user()->isAdmin()) || (auth()->user()->isStock()))
                                {{$draw->getTotalTickets()->count()}}
                            @elseif(auth()->user()->isSupervisor())
                                {{$draw->getTotalSupervisorTickets(auth()->user()->id)->count()}}
                            @endif
                        </span>
                    </div>
                    @if((auth()->user()->isAdmin()) || (auth()->user()->isStock()))
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Количество выданных билетов супервайзерам
                            </span>
                                <span class="m-widget13__text m-widget13__text-bolder">
                                {{$draw->getSharedTicketsToSupervisor()->count()}}
                            </span>
                        </div>
                    @endif
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Количество выданных билетов реализаторам
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder">
                            {{$draw->getSharedTicketsToSeller()->count()}}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc m--align-right">
                            Количество проданных билетов
                        </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                            @if((auth()->user()->isAdmin()) || (auth()->user()->isStock()))
                                {{$draw->getSoldTickets()->count()}}
                            @elseif(auth()->user()->isSupervisor())
                                {{$draw->getSoldTicketsBySupervisor(auth()->user()->id)->count()}}
                            @endif

                        </span>
                    </div>
                    <div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Количество утилизированных билетов
					</span>
                        <span class="m-widget13__text m-widget13__text-bolder">
						{{$draw->getReturnedTickets()->count()}}
					</span>
                    </div>
                    <div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Статус
					</span>
                        <span class="m-widget13__text m-widget13__text-bolder">
						{!!$draw->getStatus()!!}
					</span>
                    </div>
                    <div class="m-widget13__action m--align-right">
                        <a href="{{route('drawLottery.show', $drawLottery)}}" class="m-widget__detalis btn btn-secondary">
                            Назад
                        </a>
                        @if((auth()->user()->isAdmin()) || (auth()->user()->isStock()))
                            <a href="{{route('drawLottery.draw.edit', [$drawLottery, $draw])}}" class="m-widget__detalis btn btn-info">
                                Редактировать
                            </a>
                            <a href="{{route('drawLottery.draw.delete', [$drawLottery, $draw])}}" class="btn btn-danger">
                                Удалить
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Все билеты
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    @if(auth()->user()->isAdmin() || auth()->user()->isStock())
                        <a href="{{route('drawLottery.draw.ticketsAdd', [$drawLottery, $draw])}}" class="btn btn-success m--margin-left-10">
                            Добавить билеты
                        </a>
                    @endif
                    <a href="{{route('drawLottery.draw.ticketsShare', [$drawLottery, $draw])}}" class="btn btn-info m--margin-left-10">
                        Выдать билеты
                    </a>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <input type="hidden" id="lotteryEdition" value="{{$draw->id}}">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input m-input--solid" placeholder="Поиск..." id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
										<span>
											<i class="jam jam-search"></i>
										</span>
									</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Search Form -->
                <!--begin: Datatable -->
                <div class="m_datatable" id="drawCreatedTickets"></div>
                <!--end: Datatable -->
            </div>
        </div>

        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Билеты с возвратом
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="{{route('drawLottery.draw.ticketsSold', [$drawLottery, $draw])}}" class="btn btn-success m--margin-left-10">
                        Остальные отметить проданные
                    </a>
                    <a href="{{route('drawLottery.draw.ticketsReturn', [$drawLottery, $draw])}}" class="btn btn-success m--margin-left-10">
                        Возврат (вручную)
                    </a>
                    <a href="{{route('drawLottery.draw.ticketsReturnScan', [$drawLottery, $draw])}}" class="btn btn-success m--margin-left-10">
                        Возврат (сканер)
                    </a>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input m-input--solid" placeholder="Поиск..." id="generalSearch2">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
										<span>
											<i class="jam jam-search"></i>
										</span>
									</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Search Form -->
                <!--begin: Datatable -->
                <div class="m_datatable" id="drawReturnedTickets"></div>
                <!--end: Datatable -->
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script src="{{asset('assets/admin/js/dataTable/drawTickets.js')}}" type="text/javascript"></script>
@endsection