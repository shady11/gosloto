@extends('admin.layouts.default')

@section('title', 'Настройки')

@section('content')

@include('admin.settings.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Редактировать настройки
					</h3>
				</div>
			</div>
		</div>
		
		<!--begin::Form-->
		{!! Form::model($settings, ['route' => ['settings.bySlug.update', $settings->slug], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
			@include('admin.settings.tickets.form', $settings)
		{!! Form::close() !!}
		<!--end::Form-->
	</div>
</div>

@endsection