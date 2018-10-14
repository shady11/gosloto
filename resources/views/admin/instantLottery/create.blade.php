@extends('admin.layouts.default')

@section('title', 'Добавить мгновенную лотерею')

@section('content')

    @include('admin.subheader.lottery')

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Добавить мгновенную лотерею
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->
            {!! Form::model($instantLottery, ['route' => 'instantLottery.store', 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
                @include('admin.instantLottery.form', $instantLottery)
            {!! Form::close() !!}
            <!--end::Form-->
        </div>
    </div>

@endsection

@section('footer')
    <script src="{{asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
@endsection