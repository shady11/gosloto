@extends('bashkaruu.layouts.default')

@section('title', 'Типы пользователей')

@section('content')

@include('bashkaruu.users.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Редактировать
					</h3>
				</div>
			</div>
		</div>
		
		<!--begin::Form-->
		{!! Form::model($userType, ['route' => ['userTypes.update', $userType], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
			@include('bashkaruu.userTypes.form', $userType)
		{!! Form::close() !!}
		<!--end::Form-->
	</div>
</div>

@endsection