<!DOCTYPE html>
<html lang="en" >

<!-- begin::Head -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>
        Metronic | Invoice v1
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            color: #212529;
            font-size: 13px;
            font-weight: 400;
            font-family:  DejaVu Sans;
            -ms-text-size-adjust: 100%;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        a {
            color: #5867dd;
            text-decoration: none;
            background-color: transparent;
            -webkit-text-decoration-skip: objects;
        }
        img {
            vertical-align: middle;
            border-style: none;
        }
        h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
            margin-bottom: .5rem;
        }
        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            margin-bottom: .5rem;
            font-weight: 500;
            line-height: 1.2;
            color: inherit;
        }
        th {
            text-align: inherit;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }
        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #f4f5f8;
        }
        .table th {
            font-weight: 500;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #f4f5f8;
        }

        /*INVOICE 2*/
        .m-invoice-2{
            page-break-after: always;
        }
        .m-invoice-2:last-child{
            page-break-after: auto;
        }
        .m-invoice-2.m-invoice-2--fit .m-invoice__wrapper .m-invoice__head .m-invoice__container {
            padding: 0
        }

        .m-invoice-2.m-invoice-2--fit .m-invoice__wrapper .m-invoice__head .m-invoice__container.m-invoice__container--centered {
            width: 100%
        }

        .m-invoice-2.m-invoice-2--fit .m-invoice__wrapper .m-invoice__body {
            padding: 6rem 5rem 0 5rem
        }

        .m-invoice-2.m-invoice-2--fit .m-invoice__wrapper .m-invoice__body.m-invoice__body--centered {
            width: 100%
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__head .m-invoice__container {
            padding: 0 5rem 0 5rem
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__head .m-invoice__container.m-invoice__container--centered {
            width: 90%;
            margin: 0 auto;
            padding: 0
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo {
            display: table;
            width: 100%;
            padding-top: 10rem;
            padding-bottom: 5rem;
            /*border-bottom: 2px solid #ebedf2;*/
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo>a {
            display: table-cell;
            text-decoration: none
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo>a>h1 {
            font-weight: 600;
            font-size: 2.7rem
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo>a:last-child {
            text-align: right
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo>a:first-child {
            vertical-align: top
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body {
            padding: 2rem 5rem 0 5rem
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body.m-invoice__body--centered {
            width: 90%;
            margin: 0 auto;
            padding: 2rem 0 0 0
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table thead tr th {
            padding: 1rem 0 .5rem 0;
            border-top: none
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table thead tr th:not(:first-child) {
            text-align: right
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tbody tr td:not(:first-child) {
            text-align: right
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table thead tr th:nth-child(2),
        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table thead tr th:last-child{
            text-align: right;
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tbody tr td ,
        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tfoot tr td {
            padding: 1rem 0 1rem 0;
            vertical-align: middle;
            border-top: none;
            font-weight: 600;
            font-size: 1.1rem
        }
        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tbody tr td:nth-child(2),
        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tbody tr td:last-child,
        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tfoot tr td:nth-child(2),
        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tfoot tr td:last-child{
            text-align: right;
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tbody tr td:not(:first-child) {
            text-align: right
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tbody tr:first-child td {
            padding-top: 2.5rem
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tbody tr:last-child td {
            padding-bottom: 2.5rem
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tfoot tr.row-foot:first-child td{
            padding-top: 2.5rem;
            border-top: 2px solid #f4f5f8;
        }
        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tfoot tr.row-foot:last-child td{
            border-top: none;
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo>a>h1 {
            color: #6f727d
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table thead tr th {
            color: #898b96
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tbody tr td {
            color: #6f727d
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tbody tr td:last-child {
            color: #f4516c
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tfoot tr.row-foot td:last-child{
            color: #6f727d;
        }


        @media print {
            html, body{
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<!-- end::Head -->

<!-- end::Body -->
<body>

@foreach($lottery_editions as $lottery_edition)

<div class="m-invoice-2">
    <div class="m-invoice__wrapper">
        <div class="m-invoice__head">
            <div class="m-invoice__container m-invoice__container--centered">
                <div class="m-invoice__logo">
                    <a href="#">
                        <h1>
                            Отчет
                        </h1>
                    </a>
                    <a href="#">
                        <img  src="http://loto.export.gov.kg/assets/demo/demo11/media/img/logo/logo-mono-small.jpg">
                    </a>
                </div>
            </div>
        </div>
        <div class="m-invoice__body m-invoice__body--centered">
            <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                Лотерея
                            </th>
                            <th>
                                Супервайзер
                            </th>
                            <th>
                                Количество билетов, шт.
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>{{$lottery_edition->getLotteryType()->name}} Тираж №{{$lottery_edition->number}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach($supervisors as $supervisor)
                                @if($lottery_edition->hasSupervisor($supervisor->id))
                                    <tr>
                                        <td>

                                        </td>
                                        <td>
                                            {{$supervisor->getFullName()}}
                                        </td>
                                        <td>
                                            {{$lottery_edition->sharedToSupervisorTickets($supervisor->id)->count()}}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="row-foot">
                            <td>

                            </td>
                            <td>
                                ИТОГО
                            </td>
                            <td>
                                {{$lottery_edition->tickets_count}}
                            </td>
                        </tr>
                        <tr class="row-foot">
                            <td>

                            </td>
                            <td>
                                Выдано
                            </td>
                            <td>
                                {{$lottery_edition->sharedTickets()->count()}}
                            </td>
                        </tr>
                        <tr class="row-foot">
                            <td>

                            </td>
                            <td>
                                Возврат
                            </td>
                            <td>
                                {{$lottery_edition->returnedTickets()->count()}}
                            </td>
                        </tr>
                        </tfoot>
                    </table>
            </div>
        </div>
    </div>
</div>
@endforeach

</body>
<!-- end::Body -->
</html>