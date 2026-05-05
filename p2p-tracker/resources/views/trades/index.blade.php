<h2>Trades</h2>

<a href="/trades/create">+ Add Trade</a>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Type</th>
        <th>USDT</th>
        <th>Bank</th>
        <th>Total</th>
        <th>Bank Fee</th>
        <th>Actions</th>
    </tr>

    @foreach($trades as $trade)
    <tr>
        <td>{{ $trade->id }}</td>
        <td>{{ $trade->type }}</td>
        <td>{{ $trade->amount_usdt }}</td>
        <td>{{ $trade->price }}</td>
        <td>{{ $trade->total_lkr }}</td>
        <td>{{ $trade->bank_fee }}</td>

        <td>
            <a href="/trades/{{ $trade->id }}">View</a>
            <a href="/trades/{{ $trade->id }}/edit">Edit</a>

            <form action="/trades/{{ $trade->id }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>