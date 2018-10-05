

<style>
    .m-invoice-1 .m-invoice__wrapper {
        overflow: hidden;
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head {
        background-size: cover;
        background-repeat: no-repeat
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container {
        padding-left: 5rem;
        padding-right: 5rem
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container.m-invoice__container--centered {
        width: 90%;
        margin: 0 auto;
        padding: 0
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo {
        display: table;
        width: 100%;
        padding-top: 10rem;
        padding-bottom: 5rem;
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo>a {
        display: table-cell;
        text-decoration: none
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo>a>h1 {
        font-weight: 600;
        font-size: 2.7rem
    }
    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo>a> img{
        width: auto;
        height: 50px;
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo>a:last-child {
        text-align: right
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo>a:first-child {
        vertical-align: top
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__desc {
        text-align: right;
        display: block;
        padding: 1rem 0 4rem 0
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__desc>span {
        display: block
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__items {
        display: table;
        width: 100%;
        padding: 5rem 0 6rem 0;
        table-layout: fixed
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__items .m-invoice__item {
        display: table-cell
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__items .m-invoice__item .m-invoice__subtitle {
        font-weight: 500;
        padding-bottom: .5rem
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__items .m-invoice__item>span {
        display: block
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__body {
        padding: 6rem 5rem 0 5rem
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__body.m-invoice__body--centered {
        width: 90%;
        margin: 0 auto;
        padding: 6rem 0 0 0
    }
    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table thead tr th {
        padding: 1rem 0 .5rem 0;
        border-top: none
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table thead tr th:not(:first-child) {
        text-align: right;
    }
    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table thead tr th:nth-child(2),
    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table thead tr th:last-child{
        text-align: right;
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tbody tr td ,
    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tfoot tr td {
        padding: 1rem 0 1rem 0;
        vertical-align: middle;
        border-top: none;
        font-weight: 600;
        font-size: 1.1rem
    }
    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tbody tr td:nth-child(2),
    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tbody tr td:last-child,
    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tfoot tr td:nth-child(2),
    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tfoot tr td:last-child{
        text-align: right;
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tbody tr td:not(:first-child) {
        text-align: right
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tbody tr:first-child td {
        padding-top: 2.5rem
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tbody tr:last-child td {
        padding-bottom: 2.5rem
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tfoot tr.row-foot:first-child td{
        padding-top: 2.5rem;
        border-top: 2px solid #f4f5f8;
    }
    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tfoot tr.row-foot:last-child td{
        border-top: none;
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo>a>h1 {
        color: #6f727d
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table thead tr th {
        color: #898b96
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tbody tr td ,
    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tfoot tr td {
        color: #6f727d
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tbody tr td:last-child {
        color: #fe21be
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__body table tfoot tr.row-foot td:last-child{
        color: #6f727d;
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__footer .m-invoice__container .m-invoice__content>span {
        color: #3f4047
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__footer .m-invoice__container .m-invoice__content>span:first-child {
        color: #7b7e8a
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__footer .m-invoice__container .m-invoice__content>span>span:last-child {
        color: #9699a2
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__footer .m-invoice__container .m-invoice__content .m-invoice__price {
        color: #fe21be
    }

    .m-invoice-1 .m-invoice__wrapper .m-invoice__footer .m-invoice__container .m-invoice__content:not(:first-child)>span:last-child {
        color: #9699a2
    }
</style>


<div class="m-portlet__body">
    <div class="m-form__section m-form__section--first">

        <div class="form-group m-form__group row">
            {!! Form::label('m_datetimepicker_2', 'Выбрать период:', ['class' => 'col-lg-3 col-form-label']); !!}
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="input-group date">
                    {!! Form::text('date_from', $report->from_date, ['id' => 'm_datetimepicker_2', 'class' => 'form-control m-input', 'placeholder' => 'Выберите дату', 'autocomplete' => 'off']) !!}
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar-check-o glyphicon-th"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="input-group date">
                    {!! Form::text('date_to', $report->to_date, ['id' => 'm_datetimepicker_2', 'class' => 'form-control m-input', 'placeholder' => 'Выберите дату', 'autocomplete' => 'off']) !!}
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar-check-o glyphicon-th"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group m-form__group row">
            {!! Form::label('has_edition', 'Тип лотереи:', ['class' => 'col-lg-3 col-form-label']); !!}
            <div class="col-lg-4">
                <label class="m-option m-option m-option--plain">
                        <span class="m-option__control">
                            <span class="m-radio m-radio--brand m-radio--check-bold">
                                <input id="hasEdition" type="radio" name="has_edition" value="1">
                                <span></span>
                            </span>
                        </span>
                    <span class="m-option__label">
                            <span class="m-option__head">
                                <span class="m-option__title">
                                    Тиражные
                                </span>
                            </span>
                            <span class="m-option__body">
                                лотереи с тиражом
                            </span>
                        </span>
                </label>
            </div>
            <div class="col-lg-4">
                <label class="m-option m-option m-option--plain">
                        <span class="m-option__control">
                            <span class="m-radio m-radio--brand m-radio--check-bold">
                                <input id="hasNoEdition" type="radio" name="has_edition" value="0">
                                <span></span>
                            </span>
                        </span>
                    <span class="m-option__label">
                            <span class="m-option__head">
                                <span class="m-option__title">
                                    Мгновенные
                                </span>
                            </span>
                            <span class="m-option__body">
                                лотереи без тиража
                            </span>
                        </span>
                </label>
            </div>
        </div>

        <div id="lotteryTypesParent" class="form-group m-form__group row m--hide">
            {!! Form::label('lottery_types', 'Выбрать лотерею(-и):', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
            <div id="lotteryTypes" class="col-lg-6 col-md-9 col-sm-12">
            </div>
        </div>

        <div id="lotteryEditionsParent" class="form-group m-form__group row m--hide">
            {!! Form::label('lottery_editions', 'Выбрать тираж(-и):', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
            <div id="lotteryEditions" class="col-lg-6 col-md-9 col-sm-12">
            </div>
        </div>

        <div class="form-group m-form__group row">
            {!! Form::label('supervisors', 'Выбрать супервайзера(-ов):', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                {!! Form::select('supervisors[]', $supervisors, null, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'title' => '-- выбрать --', 'multiple', 'data-actions-box' => 'true', 'data-select-all-text' => 'Выбрать всеx', 'data-deselect-all-text' => 'Отменить']) !!}
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!! Form::label('users', 'Выбрать реализатора(-ов):', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                {!! Form::select('users[]', $users, null, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'title' => '-- выбрать --', 'multiple', 'data-actions-box' => 'true', 'data-select-all-text' => 'Выбрать всеx', 'data-deselect-all-text' => 'Отменить']) !!}
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
                    Создать
                </button>
                <a href="#" onclick="window.history.back();" class="btn btn-secondary">
                    Назад
                </a>
            </div>
        </div>
    </div>
</div>