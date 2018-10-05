@extends('admin.layouts.default')

@section('title', 'Пользователи')

@section('content')

@include('admin.users.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Список пользователей
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				@if(auth()->user()->isAdmin())
					<a href="{{route('userTypes.create')}}" class="btn btn-info m--margin-left-10">
						Добавить тип
					</a>
				@endif
				<a href="{{route('users.create')}}" class="btn btn-success m--margin-left-10">
					Добавить пользователя
				</a>
			</div>
		</div>
		<div class="m-portlet__body">
			<!--begin: Search Form -->
			<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
				<div class="row align-items-center">
					<div class="col-xl-8 order-2 order-xl-1">
						<div class="form-group m-form__group row align-items-center">
							<div class="col-md-4">
								<div class="m-form__group m-form__group--inline">
									<div class="m-form__label">
										<label>
											Статус:
										</label>
									</div>
									<div class="m-form__control">
										<select class="form-control m-bootstrap-select m-bootstrap-select--solid" id="m_form_status">
											<option value="">
												Все
											</option>
											<option value="1">
												Активные
											</option>
											<option value="2">
												Неактивные
											</option>
										</select>
									</div>
								</div>
								<div class="d-md-none m--margin-bottom-10"></div>
							</div>
							<div class="col-md-4">
								<div class="m-form__group m-form__group--inline">
									<div class="m-form__label">
										<label class="m-label m-label--single">
											Тип:
										</label>
									</div>
									<div class="m-form__control">
										<select class="form-control m-bootstrap-select m-bootstrap-select--solid" id="m_form_type">
											<option value="">
												Все
											</option>
											@foreach($userTypes as $userType)
												<option value="{{$userType->id}}">
													{{$userType->name}}
												</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="d-md-none m--margin-bottom-10"></div>
							</div>
							<div class="col-md-4">
								<div class="m-input-icon m-input-icon--left">
									<input type="text" class="form-control m-input m-input--solid" placeholder="Поиск..." id="generalSearch">
									<span class="m-input-icon__icon m-input-icon__icon--left">
										<span>
											<i class="jam jam-search"></i>
										</span>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--end: Search Form -->
			<!--begin: Datatable -->
			<div class="m_datatable" id="server_record_selection"></div>
			<!--end: Datatable -->
		</div>
	</div>
</div>

@endsection

@section('footer')
<script src="{{asset('assets/admin/js/dataTable/users.js')}}" type="text/javascript"></script>
@endsection