<input type="hidden" name="number" value="{{$lotteryEdition->number}}">

<div class="m-portlet__body">
    <div class="m-form__section m-form__section--first">

        <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">
                Номера билетов:
            </label>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12 text-right">
                от
            </label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                {!! Form::text('lotteryTicketsFrom', null, ['id' => 'lotteryTicketsFrom', 'class' => 'form-control m-input']) !!}
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12 text-right">
                до
            </label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                {!! Form::text('lotteryTicketsTo', null, ['id' => 'lotteryTicketsFrom', 'class' => 'form-control m-input']) !!}
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