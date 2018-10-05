<input type="hidden" name="number" value="{{$lotteryEdition->number}}">

<div class="m-portlet__body">
    <div class="m-form__section m-form__section--first">

        @if($ticket_number)
            <div class="m-alert m-alert--outline m-alert--outline-2x alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <strong>
                    Сохранено!
                </strong>
                Билет с номером {{$ticket_number}} был отмечен как "Возврат".
            </div>
        @endif

        <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">
                Номер билета:
            </label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                {!! Form::text('ticket_number', null, ['id' => 'ticket_number', 'class' => 'form-control m-input', 'autofocus']) !!}
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
                <a href="{{route('lotteryEditions.show', $lotteryEdition)}}" class="btn btn-secondary">
                    Назад
                </a>
            </div>
        </div>
    </div>
</div>