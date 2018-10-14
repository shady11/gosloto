@extends('admin.layouts.default')

@section('title', 'Редактировать билет тиража')

@section('content')

    @include('admin.lotteries.subheader')

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Редактировать билет тиража
                        </h3>
                    </div>
                </div>
            </div>

            <form action="{{ route('drawLottery.draw.ticket.update', [$drawLottery, $draw, $ticket->id]) }}" method="POST" class="m-form">

                {!! Form::token() !!}

                <div class="m-portlet__body">
                    <div class="m-form__section m-form__section--first">

                        <div class="form-group m-form__group row">
                            {!! Form::label('status', 'Статус:', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                {!! Form::select('status', $statuses, $ticket->status, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'title' => '-- выбрать --']) !!}
                            </div>
                        </div>

                        @if(auth()->user()->isAdmin() || auth()->user()->isStock())
                            <div class="form-group m-form__group row">
                                {!! Form::label('supervisor_id', 'Супервайзер:', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    {!! Form::select('supervisor_id', $supervisors, $ticket->supervisor_id, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'title' => '-- выбрать --']) !!}
                                </div>
                            </div>
                        @endif

                        <div class="form-group m-form__group row">
                            {!! Form::label('seller_id', 'Пользователь:', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                {!! Form::select('seller_id', $sellers, $ticket->seller_id, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'title' => '-- выбрать --']) !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            {!! Form::label('m_datetimepicker_2', 'Дата продажи:', ['class' => 'col-lg-3 col-form-label']); !!}
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-group date">
                                    {!! Form::text('sold_date', $ticket->sold_at, ['id' => 'm_datetimepicker_2', 'class' => 'form-control m-input', 'placeholder' => 'Выберите дату и время', 'autocomplete' => 'off']) !!}
                                    <div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar-check-o glyphicon-th"></i>
									</span>
                                    </div>
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
                                <a onclick="window.history.back();" class="btn btn-secondary">
                                    Назад
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection

@section('footer')
    <script src="{{asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
@endsection