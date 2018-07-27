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
						Типы пользователей
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<a href="{{route('userTypes.create')}}" class="btn btn-info m--margin-left-10">
					Добавить тип
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
			<!--begin: Selected Rows Group Action Form -->
			<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30 collapse" id="m_datatable_group_action_form1">
				<div class="row align-items-center">
					<div class="col-xl-12">
						<div class="m-form__group m-form__group--inline">
							<div class="m-form__label m-form__label-no-wrap">
								<label class="m--font-bold m--font-danger-">
									Selected
									<span id="m_datatable_selected_number1"></span>
									records:
								</label>
							</div>
							<div class="m-form__control">
								<div class="btn-toolbar">
									<div class="dropdown">
										<button type="button" class="btn btn-accent btn-sm dropdown-toggle" data-toggle="dropdown">
											Update status
										</button>
										<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
											<a class="dropdown-item" href="#">
												Pending
											</a>
											<a class="dropdown-item" href="#">
												Delivered
											</a>
											<a class="dropdown-item" href="#">
												Canceled
											</a>
										</div>
									</div>
									&nbsp;&nbsp;&nbsp;
									<button class="btn btn-sm btn-danger" type="button" id="m_datatable_delete_all1">
										Delete All
									</button>
									&nbsp;&nbsp;&nbsp;
									<button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#m_modal_fetch_id_server">
										Fetch Selected Records
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--end: Selected Rows Group Action Form -->
			<!--begin: Datatable -->
			<div class="m_datatable" id="server_record_selection"></div>
			<!--end: Datatable -->
		</div>
	</div>
</div>

@endsection

@section('footer')
<script src="{{asset('assets/admin/js/dataTable/userTypes.js')}}" type="text/javascript"></script>
@endsection