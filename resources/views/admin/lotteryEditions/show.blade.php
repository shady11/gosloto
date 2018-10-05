@extends('admin.layouts.default')

@section('title', 'Тиражи лотерей')

@section('content')

@include('admin.lotteries.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--full-height ">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						{{$lotteryType->name}} Тираж №{{$lotteryEdition->number}}
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div class="m-widget13">
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Лотерея
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$lotteryType->name}}
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Номер тиража
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$lotteryEdition->number}}
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Общее количество билетов
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$lotteryEdition->totalTickets()->count()}}
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Количество выданных билетов
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						@if((auth()->user()->isAdmin()) || (auth()->user()->isStock()))
							{{$lotteryEdition->sharedTickets()->count()}}
						@else
							{{$lotteryEdition->sharedTicketsToUser()->count()}}
						@endif
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Количество проданных билетов
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$lotteryEdition->soldTickets()->count()}}
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Количество возвращенных билетов
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$lotteryEdition->returnedTickets()->count()}}
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Статус
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{!!$lotteryEdition->getStatus()!!}
					</span>
				</div>
				<div class="m-widget13__action m--align-right">
					<a href="{{route('lotteryTypes.index', $lotteryType)}}" class="m-widget__detalis btn btn-secondary">
						Назад
					</a>
					@if((auth()->user()->isAdmin()) || (auth()->user()->isStock()))
						<a href="{{route('lottery.lotteryEdition.edit', [$lotteryType, $lotteryEdition])}}" class="m-widget__detalis btn btn-info">
							Редактировать
						</a>
						<a href="{{route('lottery.lotteryEdition.delete', [$lotteryType, $lotteryEdition])}}" class="btn btn-danger">
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
				<a href="{{route('lotteryEditionTickets.addTickets', $lotteryEdition)}}" class="btn btn-success m--margin-left-10">
					Добавить билеты
				</a>
				<a href="{{route('lotteryEditionTickets.addUser', $lotteryEdition)}}" class="btn btn-info m--margin-left-10">
					Оформить билеты
				</a>
			</div>
		</div>
		<div class="m-portlet__body">
			<!--begin: Search Form -->
			<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
				<input type="hidden" id="lotteryEdition" value="{{$lotteryEdition->id}}">
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
			<div class="m_datatable" id="data_tickets"></div>
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
                <a href="{{route('lotteryEditionTickets.addTicketsBack', $lotteryEdition)}}" class="btn btn-success m--margin-left-10">
                    Возврат
                </a>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <input type="hidden" id="lotteryEdition" value="{{$lotteryEdition->id}}">
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
            <div class="m_datatable" id="data_tickets_back"></div>
            <!--end: Datatable -->
        </div>
    </div>
</div>

@endsection

@section('footer')
<script src="{{asset('assets/admin/js/dataTable/lotteryEditionTickets.js')}}" type="text/javascript"></script>
@endsection