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
                            Возврат
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->
            <form action="{{ route('drawLottery.draw.ticketsReturnStore', [$drawLottery, $draw]) }}" method="POST" class="m-form">

                {!! Form::token() !!}

                <div class="m-portlet__body">
                    <div class="m-form__section m-form__section--first">

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
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12 text-right">
                                до
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                {!! Form::text('ticketsTo', null, ['id' => 'ticketsTo', 'class' => 'form-control m-input']) !!}
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
                                <a href="{{route('drawLottery.draw.show', [$drawLottery, $draw])}}" class="btn btn-secondary">
                                    Назад
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>

@endsection

@section('footer')
@endsection