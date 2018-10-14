@if($drawLotteries->isNotEmpty())

    <table>
        <tr>
            <td>Тиражные лотереи</td>
        </tr>
    </table>

    <table class="table" border="1px">
        <thead>
            <tr>
                <th>Лотерея</th>
                <th>Количество тиражей</th>
            </tr>
        </thead>

        <tbody>
            @foreach($drawLotteries as $drawLottery)
                <tr>
                    <td>{{$drawLottery->name}}</td>
                    <td>{{$drawLottery->getDraws()->count()}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @foreach($draws as $draw)

        <table class="table" border="1px">
            <thead>
                <tr>
                    <th>Лотерея</th>
                    <th>Тираж</th>
                    <th>Общее количество билетов, шт.</th>
                    <th>Выданные билеты, шт.</th>
                    <th>Проданные билеты, шт.</th>
                    <th>Утилизированные билеты, шт.</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>{{$draw->getLottery->name}}</td>
                    <td>{{$draw->draw_number}}</td>
                    <td>{{$draw->getTotalTickets()->count()}}</td>
                    <td>{{$draw->getSharedTicketsToSupervisor()->count()}}</td>
                    <td>{{$draw->getSoldTickets()->count()}}</td>
                    <td>{{$draw->getReturnedTickets()->count()}}</td>
                </tr>
            </tbody>
        </table>

        <table class="table" border="1px">
            <thead>
                <tr>
                    <th>Супервайзер</th>
                    <th>Выданные билеты, шт.</th>
                    <th>Проданные билеты, шт.</th>
                    <th>Утилизированные билеты, шт.</th>
                </tr>
            </thead>

            <tbody>
                @foreach($supervisors as $supervisor)
                    @if($draw->hasSupervisor($supervisor->id))
                        <tr>
                            <td>{{$supervisor->getFullName()}}</td>
                            <td>{{$supervisor->getTotalDrawTickets($draw)->count()}}</td>
                            <td>{{$supervisor->getSoldDrawTickets($draw)->count()}}</td>
                            <td>{{$supervisor->getReturnedDrawTickets($draw)->count()}}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    @endforeach

@endif

@if($instantLotteries->isNotEmpty())

    <table>
        <tr></tr>
        <tr>
            <td>Моментальные лотереи</td>
        </tr>
    </table>

    <table class="table" border="1px">
        <thead>
            <tr>
                <th>Лотерея</th>
                <th>Количество билетов</th>
                <th>Количество билетов</th>
            </tr>
        </thead>

        <tbody>
            @foreach($instantLotteries as $instantLottery)
                <tr>
                    <td>{{$instantLottery->name}}</td>
                    <td>{{$instantLottery->tickets_count}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($sharedTickets->isNotEmpty())
        <table class="table" border="1px">
            <thead>
            <tr>
                <th>Супервайзер</th>
                <th>Лотерея</th>
                <th>Выданные билеты, шт.</th>
                <th>Проданные билеты, шт.</th>
                <th>Утилизированные билеты, шт.</th>
            </tr>
            </thead>

            <tbody>

            @foreach($sharedTickets as $sharedTicket)

                <tr>
                    <td>{{$sharedTicket->getSupervisor->getFullName()}}</td>
                    <td>{{$sharedTicket->getLottery->name}}</td>
                    <td>{{$sharedTicket->tickets_count}}</td>
                    <td>{{$sharedTicket->sold_tickets_count}}</td>
                    <td>{{$sharedTicket->returned_tickets_count}}</td>
                </tr>

            @endforeach

            </tbody>
        </table>
    @endif

@endif