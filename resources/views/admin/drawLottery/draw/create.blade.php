@extends('admin.layouts.default')

@section('title', 'Добавить тираж лотереи')

@section('content')

    @include('admin.subheader.lottery')

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Добавить тираж лотереи
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->
        {!! Form::model($draw, ['route' => ['drawLottery.draw.store', $drawLottery], 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
        @include('admin.drawLottery.draw.form', $draw)
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>

@endsection

