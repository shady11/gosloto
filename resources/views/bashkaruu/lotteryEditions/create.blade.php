@extends('bashkaruu.layouts.default')

@section('title', 'Тиражи лотерей')

@section('content')

@include('bashkaruu.lotteries.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Добавить тираж
					</h3>
				</div>
			</div>
		</div>
		
		<!--begin::Form-->
		{!! Form::model($lotteryEdition, ['route' => 'lotteryEditions.store', 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
			@include('bashkaruu.lotteryEditions.form', $lotteryEdition)
		{!! Form::close() !!}
		<!--end::Form-->
	</div>
</div>

@endsection

@section('footer')
<script src="{{asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
@endsection