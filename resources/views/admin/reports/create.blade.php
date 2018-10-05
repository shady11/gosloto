@extends('admin.layouts.default')

@section('content')

    @include('admin.lotteries.subheader')

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Создать отчет
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->
        {!! Form::model($report, ['route' => 'reports.store', 'enctype' => 'multipart/form-data', 'class' => 'm-form']) !!}
        @include('admin.reports.form', $report)
        {!! Form::close() !!}
        <!--end::Form-->
        </div>
    </div>

@endsection

@section('footer')
    <script src="{{asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
    <script>
        $('input[name=has_edition]').change(function () {
            getLotteryTypes($(this).val());
            if($(this).val() == 0 && !$('#lotteryEditionsParent').hasClass('m--hide')){
                $('#lotteryEditionsParent').addClass('m--hide');
            }
        });

        function getLotteryTypes(value) {

            var url = '/reportGetLotteryTypes';

            $.ajax
            ({
                type: "POST",
                url: url,
                data: {
                    has_edition: value
                },
                cache: false,
                success: function (data) {
                    $('#lotteryTypes').html(data);
                    $('.m_selectpicker').selectpicker('refresh');
                    $('#lotteryTypesParent').removeClass('m--hide');
                }
            });
        }

        function getLotteryEditions(el) {

            var url = '/reportGetLotteryEditions';

            $.ajax
            ({
                type: "POST",
                url: url,
                data: {
                    ids: $('#lotteryTypeSelect').val()
                },
                cache: false,
                success: function (data) {
                    $('#lotteryEditions').html(data);
                    $('.m_selectpicker').selectpicker('refresh');
                    $('#lotteryEditionsParent').removeClass('m--hide');
                }
            });
        }


    </script>
@endsection