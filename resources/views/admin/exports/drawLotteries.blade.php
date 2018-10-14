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