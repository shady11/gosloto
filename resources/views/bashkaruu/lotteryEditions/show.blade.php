@extends('bashkaruu.layouts.default')

@section('title', 'Тиражи лотерей')

@section('content')

@include('bashkaruu.lotteries.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--full-height ">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Тираж №{{$lotteryEdition->number}}
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div class="m-widget13">
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
						Количество билетов:
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$lotteryEdition->tickets_count}}
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Тип лотереи:
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$lotteryEdition->getLotteryType()->name}}
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Статус:
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{!!$lotteryEdition->getStatus()!!}
					</span>
				</div>
				<div class="m-widget13__action m--align-right">
					<a href="{{route('lotteryEditions.index')}}" class="m-widget__detalis btn btn-secondary">
						Назад
					</a>
					<a href="{{route('lotteryEditions.edit', $lotteryEdition)}}" class="m-widget__detalis btn btn-info">
						Редактировать
					</a>
					<a href="{{route('lotteryEditions.delete', $lotteryEdition)}}" class="btn btn-danger">
						Удалить
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

