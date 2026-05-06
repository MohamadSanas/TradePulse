<h2>Add Trade</h2>

<form method="POST" action="/trades">
    @csrf

    <select name="type">
        <option value="buy">Buy</option>
        <option value="sell">Sell</option>
    </select>

    <input name="amount_usdt" placeholder="USDT">
    <input name="bank_fee" placeholder="Bank Fee">
    <input name="total_lkr" placeholder="Total LKR">
    <input name="fee" placeholder="App Fee">

    <button type="submit">Save</button>
</form>