<div class="m-portlet__body">
	<div class="m-form__section m-form__section--first">

		<div class="form-group m-form__group row">
			{!! Form::label('number', 'Номер тиража:', ['class' => 'col-lg-3 col-form-label']); !!}
			<div class="col-lg-6">
				@if($lotteryEdition->id)
					{!! Form::text('number', null, ['id' => 'number', 'class' => 'form-control m-input', 'disabled']) !!}
				@else
					{!! Form::text('number', null, ['id' => 'number', 'class' => 'form-control m-input']) !!}
				@endif
			</div>
		</div>

		<div class="form-group m-form__group row">
			{!! Form::label('tickets_count', 'Количество билетов:', ['class' => 'col-lg-3 col-form-label']); !!}
			<div class="col-lg-6">
				@if($lotteryEdition->id)
					{!! Form::text('tickets_count', null, ['id' => 'tickets_count', 'class' => 'form-control m-input', 'disabled']) !!}
				@else
					{!! Form::text('tickets_count', null, ['id' => 'tickets_count', 'class' => 'form-control m-input']) !!}
				@endif
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
				@if($lotteryEdition->id)
					{!! Form::text('lotteryTicketsFrom', null, ['id' => 'lotteryTicketsFrom', 'class' => 'form-control m-input', 'disabled']) !!}
				@else
					{!! Form::text('lotteryTicketsFrom', null, ['id' => 'lotteryTicketsFrom', 'class' => 'form-control m-input']) !!}
				@endif
			</div>
		</div>

		<div class="form-group m-form__group row">
			<label class="col-form-label col-lg-3 col-sm-12 text-right">
				до
			</label>
			<div class="col-lg-4 col-md-9 col-sm-12">
				@if($lotteryEdition->id)
					{!! Form::text('lotteryTicketsTo', null, ['id' => 'lotteryTicketsFrom', 'class' => 'form-control m-input', 'disabled']) !!}
				@else
					{!! Form::text('lotteryTicketsTo', null, ['id' => 'lotteryTicketsFrom', 'class' => 'form-control m-input']) !!}
				@endif
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