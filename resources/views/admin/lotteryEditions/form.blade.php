<div class="m-portlet__body">
	<div class="m-form__section m-form__section--first">
		<div class="form-group m-form__group row">
			{!! Form::label('number', 'Номер тиража:', ['class' => 'col-lg-3 col-form-label']); !!}
			<div class="col-lg-6">
				{!! Form::text('number', null, ['id' => 'number', 'class' => 'form-control m-input']) !!}
			</div>
		</div>
		<div class="form-group m-form__group row">
			{!! Form::label('tickets_count', 'Количество билетов:', ['class' => 'col-lg-3 col-form-label']); !!}
			<div class="col-lg-6">
				{!! Form::text('tickets_count', null, ['id' => 'tickets_count', 'class' => 'form-control m-input']) !!}
			</div>
		</div>
		<div class="form-group m-form__group row">
			<label class="col-form-label col-lg-3 col-sm-12">
				Выбрать билеты:
			</label>
		</div>

		<div class="form-group m-form__group row">
			<label class="col-form-label col-lg-3 col-sm-12 text-right">
				от
			</label>
			<div class="col-lg-4 col-md-9 col-sm-12">
				{!! Form::text('lotteryTicketsFrom', null, ['id' => 'lotteryTicketsFrom', 'class' => 'form-control m-input']) !!}
				{{-- <select name="lotteryTicketsFrom" class="form-control m_selectpicker" title="-- выбрать --" id="m_selectpicker_from" onchange="getLotteryTicketsTo(this.value)">
					@for($i = 0; $i < $lotteryEdition->tickets_count; $i+=$step)
						@if($lotteryEditionTickets->contains('ticket_number', str_pad($i, (strlen($lotteryEdition->tickets_count)-1), "0", STR_PAD_LEFT)))
							<option value="{{$i}}" >
								{{$i}}
							</option>
						@endif
					@endfor
				</select> --}}
			</div>
		</div>

		<div class="form-group m-form__group row">
			<label class="col-form-label col-lg-3 col-sm-12 text-right">
				до
			</label>
			<div class="col-lg-4 col-md-9 col-sm-12">
				{!! Form::text('lotteryTicketsTo', null, ['id' => 'lotteryTicketsFrom', 'class' => 'form-control m-input']) !!}
				{{-- <select name="lotteryTicketsTo" class="form-control m_selectpicker" title="-- выбрать --" id="m_selectpicker_to">					
				</select> --}}
			</div>
		</div>
		<div class="form-group m-form__group row">
			{!! Form::label('lottery_type', 'Тип:', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
			<div class="col-lg-6 col-md-9 col-sm-12">
				{!! Form::select('lottery_type', $lotteryTypes, null, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'title' => '-- выбрать --']) !!}
			</div>
		</div>
		<div class="m-form__group form-group row">
			<label class="col-lg-3 col-form-label">
				Статус:
			</label>
			<div class="col-lg-6">
				<div class="m-checkbox-inline">
					<label class="m-checkbox">
						{!! Form::hidden('active', 0) !!}
						{!! Form::checkbox('active', 1, null, ["id" => "active", "class" => "styled"]) !!}
						&nbsp;
						<span></span>
					</label>									
				</div>
			</div>
		</div>
	</div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
	<div class="m-form__actions m-form__actions">
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<button type="submit" class="btn btn-success">
					Сохранить
				</button>
				<a href="#" onclick="window.history.back();" class="btn btn-secondary">
					Назад
				</a>
			</div>
		</div>
	</div>
</div>