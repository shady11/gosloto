@extends('admin.layouts.default')

@section('title', 'Пользователи')

@section('content')

@include('admin.users.subheader')

<div class="m-content">
	<div class="m-portlet m-portlet--full-height ">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						{{$user->getFullName()}}
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div class="m-widget13">
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Аватар
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						<span class="m-widget__avatar">
							<img src="{{asset($user->avatar)}}" alt="{{$user->getFullName()}}">
						</span>
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						ФИО
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$user->getFullName()}}
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Логин
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$user->login}}
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Email
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$user->email}}
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Должность
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{{$user->getUserType()->name}}
					</span>
				</div>
				<div class="m-widget13__item">
					<span class="m-widget13__desc m--align-right">
						Статус
					</span>
					<span class="m-widget13__text m-widget13__text-bolder">
						{!!$user->getStatus()!!}
					</span>
				</div>
				<div class="m-widget13__action m--align-right">
					<a href="{{route('users.index')}}" class="m-widget__detalis btn btn-secondary">
						Назад
					</a>
					<a href="{{route('users.edit', $user)}}" class="m-widget__detalis btn btn-info">
						Редактировать
					</a>
					<a href="{{route('users.delete', $user)}}" class="btn btn-danger">
						Удалить
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection