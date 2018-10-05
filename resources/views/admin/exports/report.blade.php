
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

    @foreach($lottery_types as $lottery_type)

        <tr>
            <td>{{$lottery_type->name}}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

            @foreach($lottery_editions as $lottery_edition)

            @if($lottery_edition->getLotteryType() == $lottery_type)

                <tr>
                   <td></td>
                   <td>{{$lottery_edition->number}} {{$lottery_type->name}}</td>
                   <td></td>
                   <td></td>
               </tr>

               @foreach($supervisors as $supervisor)

                   @if($lottery_edition->hasSupervisor($supervisor->id))
                       <tr>
                           <td></td>
                           <td></td>
                           <td>
                               {{$supervisor->getFullName()}}
                           </td>
                           <td>
                               {{$lottery_edition->sharedToSupervisorTickets($supervisor->id)->count()}}
                           </td>
                       </tr>
                   @endif

               @endforeach

               <tr>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
               </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        ИТОГО
                    </td>
                    <td>
                        {{$lottery_edition->tickets_count}}
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        Выдано
                    </td>
                    <td>
                        {{$lottery_edition->sharedTickets()->count()}}
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        Возврат
                    </td>
                    <td>
                        {{$lottery_edition->returnedTickets()->count()}}
                    </td>
                </tr>

            @endif

        @endforeach

    @endforeach

</table>