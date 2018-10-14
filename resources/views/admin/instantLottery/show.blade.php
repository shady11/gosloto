@extends('admin.layouts.default')

@section('title', 'Мгновенная лотерея')

@section('content')

@include('admin.lotteries.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--full-height ">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Мгновенная лотерея {{$instantLottery->name}}
					</h3>
				</div>
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
						Количество билетов:
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$instantLottery->tickets_count}}
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Статус:
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{!!$instantLottery->getStatus()!!}
					</span>
				</div>
				<div class="m-widget13__action m--align-right">
					<a href="{{route('lottery.index')}}" class="m-widget__detalis btn btn-secondary">
						Назад
					</a>
					@if((auth()->user()->isAdmin()) || (auth()->user()->isStock()))
						<a href="{{route('instantLottery.edit', $instantLottery)}}" class="m-widget__detalis btn btn-info">
							Редактировать
						</a>
						<a href="{{route('instantLottery.delete', $instantLottery)}}" class="btn btn-danger">
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
						Выдача билетов
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<a href="{{route('instantLottery.sharedTicket.create', $instantLottery)}}" class="btn btn-success m--margin-left-10">
					Выдача билетов
				</a>
			</div>
		</div>
		<div class="m-portlet__body">
			<!--begin: Search Form -->
			<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
				<input type="hidden" id="lottery" value="{{$instantLottery->id}}">
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
			<div class="m_datatable" id="server_record_selection"></div>
			<!--end: Datatable -->
		</div>
	</div>
</div>

@endsection

@section('footer')
<script src="{{asset('assets/admin/js/dataTable/instantLotterySharedTickets.js')}}" type="text/javascript"></script>
@endsection