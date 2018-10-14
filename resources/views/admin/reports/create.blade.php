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

        $('input[name=drawLotteriesCheckbox]').change(function () {
            if($(this).prop('checked')){
                getDrawLotteries();
            }
        });

        $('input[name=instantLotteriesCheckbox]').change(function () {
            if($(this).prop('checked')){
                getInstantLotteries();
            }
        });

        function getDrawLotteries() {

            $.ajax
            ({
                type: "GET",
                url: '/reportGetDrawLotteries',
                cache: false,
                success: function (data) {
                    $('#drawLotteries').html(data);
                    $('.m_selectpicker').selectpicker('refresh');
                    $('#lotteryTypesParent').removeClass('m--hide');
                }
            });
        }

        function getInstantLotteries() {

            $.ajax
            ({
                type: "GET",
                url: '/reportGetInstantLotteries',
                cache: false,
                success: function (data) {
                    $('#instantLotteries').html(data);
                    $('.m_selectpicker').selectpicker('refresh');
                    $('#lotteryTypesParent').removeClass('m--hide');
                }
            });
        }

        function getDraws(el) {

            $.ajax
            ({
                type: "GET",
                url: '/reportGetDraws',
                data: {
                    ids: $('#drawLotterySelect').val()
                },
                cache: false,
                success: function (data) {
                    $('#draws').html(data);
                    $('.m_selectpicker').selectpicker('refresh');
                    $('#lotteryEditionsParent').removeClass('m--hide');
                }
            });
        }


    </script>
@endsection