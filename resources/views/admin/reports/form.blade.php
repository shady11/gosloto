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
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('drawLotteriesCheckbox', 1, null, ["id" => "drawLotteriesCheckbox"]) !!}
                        Тиражные
                        <span></span>
                    </label>
                </div>
                <span class="m-form__help">
                    лотереи с тиражом
                </span>
            </div>
            <div class="col-lg-4">
                <div class="m-checkbox-inline">
                    <label class="m-checkbox">
                        {!! Form::checkbox('instantLotteriesCheckbox', 1, null, ["id" => "instantLotteriesCheckbox"]) !!}
                        Мгновенные
                        <span></span>
                    </label>
                </div>
                <span class="m-form__help">
                    лотереи без тиража
                </span>
            </div>
        </div>

        <div id="lotteryTypesParent" class="form-group m-form__group row m--hide">
            {!! Form::label('lottery_types', 'Выбрать лотерею(-и):', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
            <div id="drawLotteries" class="col-lg-4 col-md-9 col-sm-12">
            </div>
            <div id="instantLotteries" class="col-lg-4 col-md-9 col-sm-12">
            </div>
        </div>

        <div id="lotteryEditionsParent" class="form-group m-form__group row m--hide">
            {!! Form::label('draws', 'Выбрать тираж(-и):', ['class' => 'col-form-label col-lg-3 col-sm-12']); !!}
            <div id="draws" class="col-lg-4 col-md-9 col-sm-12">
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
                {!! Form::select('sellers[]', $users, null, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'title' => '-- выбрать --', 'multiple', 'data-actions-box' => 'true', 'data-select-all-text' => 'Выбрать всеx', 'data-deselect-all-text' => 'Отменить']) !!}
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