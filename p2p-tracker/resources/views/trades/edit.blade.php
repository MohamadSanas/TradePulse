<h2>Edit Trade</h2>

<form method="POST" action="/trades/{{ $trade->id }}">
    @csrf
    @method('PUT')

    <select name="type">
        <option value="buy" {{ $trade->type == 'buy' ? 'selected' : '' }}>Buy</option>
        <option value="sell" {{ $trade->type == 'sell' ? 'selected' : '' }}>Sell</option>
    </select>

    <input name="amount_usdt" value="{{ $trade->amount_usdt }}">
    <input name="price" value="{{ $trade->price }}">
    <input name="total_lkr" value="{{ $trade->total_lkr }}">
    <input name="bank_fee" value="{{ $trade->bank_fee }}">

    <button type="submit">Update</button>
</form>