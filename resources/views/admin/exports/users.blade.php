asd
    <table class="table" border="1px">
        <thead>
        <tr>
            <th>
                Лотерея
            </th>
            <th>
                Тираж
            </th>
            <th>
                Супервайзер
            </th>
            <th>
                Количество билетов, шт.
            </th>
        </tr>
        </thead>

        @foreach($lottery_editions as $lottery_edition)

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
        <tr></tr>
        <tfoot>
        <tr>
            <td>

            </td>
            <td>
                ИТОГО
            </td>
            <td>
                {{$lottery_edition->tickets_count}}
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>
                Выдано
            </td>
            <td>
                {{$lottery_edition->sharedTickets()->count()}}
            </td>
        </tr>
        <tr>
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
        <tr>
        </tr>
        @endforeach
    </table>