<h2>Trades</h2>

<a href="/trades/create" style="padding-bottom: 10px; display: inline-block;">+ Add Trade</a><br>

<h3 style="padding-bottom: 5px; display: inline-block;">Buys</h3>
<h3>Buy Trades</h3>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>USDT</th>
        <th>Bank Fee</th>
        <th>Total</th>
        <th>App Fee(%)</th>
        <th>Actions</th>
    </tr>

    @foreach($buyTrades as $trade)
    <tr>
        <td>{{ $trade->id }}</td>
        <td>{{ $trade->amount_usdt }}</td>
        <td>{{ $trade->bank_fee }}</td>
        <td>{{ $trade->total_lkr }}</td>
        <td>{{ $trade->fee }}</td>
        <td><a href="/trades/{{ $trade->id }}">View</a> 
            <a href="/trades/{{ $trade->id }}/edit">Edit</a> 
            <form action="/trades/{{ $trade->id }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<h3>Sell Trades</h3>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>USDT</th>
        <th>Bank Fee</th>
        <th>Total</th>
        <th>App Fee(%)</th>
        <th>Actions</th>
    </tr>

    @foreach($sellTrades as $trade)
    <tr>
        <td>{{ $trade->id }}</td>
        <td>{{ $trade->amount_usdt }}</td>
        <td>{{ $trade->bank_fee }}</td>
        <td>{{ $trade->total_lkr }}</td>
        <td>{{ $trade->fee }}</td>
        <td><a href="/trades/{{ $trade->id }}">View</a> 
            <a href="/trades/{{ $trade->id }}/edit">Edit</a> 
            <form action="/trades/{{ $trade->id }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>