@extends('admin.layouts.default')

@section('title', 'Типы пользователей')

@section('content')

@include('admin.users.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Добавить тип пользователя
					</h3>
				</div>
			</div>
		</div>
		
		<!--begin::Form-->
		{!! Form::model($userType, ['route' => 'userTypes.store', 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
			@include('admin.userTypes.form', $userType)
		{!! Form::close() !!}
		<!--end::Form-->
	</div>
</div>

@endsection

