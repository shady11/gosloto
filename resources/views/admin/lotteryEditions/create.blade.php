@extends('admin.layouts.default')

@section('title', 'Тиражи лотерей')

@section('content')

@include('admin.lotteries.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Добавить тираж {{$lotteryType->name}}
					</h3>
				</div>
			</div>
		</div>
		
		<!--begin::Form-->
		{!! Form::model($lotteryEdition, ['route' => ['lottery.lotteryEdition.store', $lotteryType], 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
			@include('admin.lotteryEditions.form', $lotteryEdition)
		{!! Form::close() !!}
		<!--end::Form-->
	</div>
</div>

@endsection

@section('footer')
<script src="{{asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
@endsection