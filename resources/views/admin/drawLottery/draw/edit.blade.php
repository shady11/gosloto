@extends('admin.layouts.default')

@section('title', 'Редактировать тираж')

@section('content')

    @include('admin.subheader.lottery')

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Редактировать тираж
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->
        {!! Form::model($draw, ['route' => ['drawLottery.draw.update', $drawLottery, $draw], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
        @include('admin.drawLottery.draw.form', [$drawLottery, $draw])
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>

@endsection