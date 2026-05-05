<h2>Add Trade</h2>

<form method="POST" action="/trades">
    @csrf

    <select name="type">
        <option value="buy">Buy</option>
        <option value="sell">Sell</option>
    </select>

    <input name="amount_usdt" placeholder="USDT">
    <input name="price" placeholder="Price">
    <input name="total_lkr" placeholder="Total">
    <input name="bank_fee" placeholder="Fee">

    <button type="submit">Save</button>
</form>