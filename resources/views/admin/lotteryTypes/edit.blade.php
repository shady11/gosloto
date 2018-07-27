@extends('admin.layouts.default')

@section('title', 'Виды лотерей')

@section('content')

@include('admin.users.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Редактировать
					</h3>
				</div>
			</div>
		</div>
		
		<!--begin::Form-->
		{!! Form::model($lotteryType, ['route' => ['lotteryTypes.update', $lotteryType], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
			@include('admin.lotteryTypes.form', $lotteryType)
		{!! Form::close() !!}
		<!--end::Form-->
	</div>
</div>

@endsection

