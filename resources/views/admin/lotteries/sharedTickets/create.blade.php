@extends('admin.layouts.default')

@section('title', 'Распределение билетов')

@section('content')

@include('admin.lotteries.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						@if(auth()->user()->isAdmin() || auth()->user()->isStock())
							Привязка супервайзера
						@elseif(auth()->user()->isSupervisor())
							Привязка реализатора
						@endif
					</h3>
				</div>
			</div>
		</div>
		
		<!--begin::Form-->
		{!! Form::model($sharedTicket, ['route' => ['sharedTickets.store', $lottery], 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
			@include('admin.lotteries.sharedTickets.form', $sharedTicket)
		{!! Form::close() !!}
		<!--end::Form-->
	</div>
</div>

@endsection

@section('footer')
<script src="{{asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
@endsection