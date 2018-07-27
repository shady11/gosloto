<div class="m-portlet__body">
	<input type="hidden" value="{{$settings->getBody()->title}}" name="title">
	<div class="m-form__section m-form__section--first">
		<div class="form-group m-form__group row">
			{!! Form::label('value', $settings->getBody()->title.':', ['class' => 'col-lg-3 col-form-label']); !!}
			<div class="col-lg-6">
				{!! Form::text('value', $settings->getBody()->value, ['id' => 'value', 'class' => 'form-control m-input']) !!}
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