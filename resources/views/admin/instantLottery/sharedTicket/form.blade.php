<input name="lottery_id" type="hidden" value="{{$instantLottery->id}}">
<input name="owner_id" type="hidden" value="{{auth()->user()->id}}">

<div class="m-portlet__body">
	<div class="m-form__section m-form__section--first">
		<div class="form-group m-form__group row">
			{!! Form::label('supervisor', 'Супервайзер:', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
			<div class="col-lg-6 col-md-9 col-sm-12">
				{!! Form::select('supervisor_id', $supervisors, null, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'title' => '-- выбрать --']) !!}
			</div>
		</div>
		<div class="form-group m-form__group row">
			{!! Form::label('user', 'Реализатор:', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
			<div class="col-lg-6 col-md-9 col-sm-12">
				{!! Form::select('seller_id', $sellers, null, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'title' => '-- выбрать --']) !!}
			</div>
		</div>
		<div class="form-group m-form__group row">
			{!! Form::label('count', 'Количество билетов:', ['class' => 'col-lg-3 col-form-label']); !!}
			<div class="col-lg-6">
				{!! Form::text('tickets_count', null, ['id' => 'count', 'class' => 'form-control m-input']) !!}
				<span class="m-form__help">Доступно {{$availableTickets}}</span>
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
				<a onclick="window.history.back();" class="btn btn-secondary">
					Назад
				</a>
			</div>
		</div>
	</div>
</div>