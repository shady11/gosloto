@extends('admin.layouts.default')

@section('title', 'Тиражи лотерей')

@section('content')

    @include('admin.lotteries.subheader')

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Выдача билетов ({{$drawLottery->name}} Тираж №{{$draw->draw_number}})
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->
            <form action="{{ route('drawLottery.draw.ticketsShareStore', [$drawLottery, $draw]) }}" method="POST" class="m-form">

                {!! Form::token() !!}

                <div class="m-portlet__body">
                    <div class="m-form__section m-form__section--first">

                        @if(auth()->user()->isAdmin() || auth()->user()->isStock())
                            <div class="form-group m-form__group row">
                                {!! Form::label('supervisor_id', 'Супервайзер:', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    {!! Form::select('supervisor_id', $supervisors, null, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'title' => '-- выбрать --']) !!}
                                </div>
                            </div>
                        @endif

                        <div class="form-group m-form__group row">
                            {!! Form::label('seller_id', 'Реализатор:', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                {!! Form::select('seller_id', $sellers, null, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'title' => '-- выбрать --']) !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Выбрать билеты:
                            </label>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12 text-right">
                                от
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                {!! Form::text('ticketsFrom', null, ['id' => 'ticketsFrom', 'class' => 'form-control m-input']) !!}
                                {{--<span class="m-form__help">от {{$draw->getTotalTickets()->first()->ticket_number}}</span>--}}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12 text-right">
                                до
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                {!! Form::text('ticketsTo', null, ['id' => 'ticketsTo', 'class' => 'form-control m-input']) !!}
                                {{--<span class="m-form__help">от {{$draw->getTotalTickets()->last()->ticket_number}}</span>--}}
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

        <!--end::Form-->
        </div>
    </div>

@endsection

@section('footer')
    <script src="{{asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-multipleselectsplitter.js')}}" type="text/javascript"></script>
@endsection