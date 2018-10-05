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
						Возврат
					</h3>
				</div>
			</div>
		</div>
		
		<!--begin::Form-->
		{!! Form::model($lotteryEdition, ['route' => ['lotteryEditionTickets.addTicketsBack.store', $lotteryEdition], 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
			@include('admin.lotteryEditions.tickets.formTicketsBack', $lotteryEdition)
		{!! Form::close() !!}
		<!--end::Form-->
	</div>
</div>

@endsection

@section('footer')
<script src="{{asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-multipleselectsplitter.js')}}" type="text/javascript"></script>
<script>
	function getLotteryTicketsTo(ticketNumber) {
        $.ajax({
            type: "POST",
            url: '/getLotteryTicketsTo',
            data: {
                ticketNumber: ticketNumber,
                lotteryEdition: {{$lotteryEdition->id}},
            },
            cache: false,
            success: function (data) {
                $('#m_selectpicker_to').html(data);
                $('#m_selectpicker_to').selectpicker('refresh');
            }
        });
    }
</script>
@endsection