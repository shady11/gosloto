<table class="table" border="1px">
    <thead>
    <tr>
        <th>Лотерея</th>
    </tr>
    </thead>

    <tbody>
    @foreach($lotteries as $lottery)
        <tr>
            <td>{{$lottery->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>