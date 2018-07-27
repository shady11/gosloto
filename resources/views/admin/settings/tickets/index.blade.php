@extends('admin.layouts.default')

@section('title', 'Настройки')

@section('content')

@include('admin.settings.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--full-height ">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						{{$settings->name}}
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div class="m-widget13">				
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						{{$settings->getBody()->title}}:
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$settings->getBody()->value}}
					</span>
				</div>				
				<div class="m-widget13__action m--align-right">
					<a href="{{route('settings.bySlug.edit', $settings->slug)}}" class="m-widget__detalis btn btn-info">
						Редактировать
					</a>
					<a href="{{route('settings.delete', $settings)}}" class="btn btn-danger">
						Удалить
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection