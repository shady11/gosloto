<div class="m-portlet__body">
	<div class="m-form__section m-form__section--first">
		<div class="form-group m-form__group row">
			{!! Form::label('name', 'Название:', ['class' => 'col-lg-3 col-form-label']); !!}
			<div class="col-lg-6">
				{!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control m-input']) !!}
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