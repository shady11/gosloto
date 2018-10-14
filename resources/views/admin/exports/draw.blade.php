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
            <td>{{$drawLottery->name}}</td>
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
        @foreach($supervisors as $row)
            @if($draw->hasSupervisor($row->id))
                <tr>
                    <td>{{$row->getFullName()}}</td>
                    <td>{{$row->getTotalDrawTickets($draw)->count()}}</td>
                    <td>{{$row->getSoldDrawTickets($draw)->count()}}</td>
                    <td>{{$row->getReturnedDrawTickets($draw)->count()}}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>