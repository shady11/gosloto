@extends('admin.layouts.default')

@section('title', 'Виды лотерей')

@section('content')

@include('admin.lotteries.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Добавить вид лотерей
					</h3>
				</div>
			</div>
		</div>
		
		<!--begin::Form-->
		{!! Form::model($row, ['route' => 'lotteryTypes.store', 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
			@include('admin.lotteryTypes.form', $row)
		{!! Form::close() !!}
		<!--end::Form-->
	</div>
</div>

@endsection

