<h2>Trade Details</h2>

<p>Type: {{ $trade->type }}</p>
<p>USDT: {{ $trade->amount_usdt }}</p>
<p>Bank fee: {{ $trade->bank_fee }}</p>
<p>Total: {{ $trade->total_lkr }}</p>
<p>Fee: {{ $trade->bank_fee }}</p>

<a href="/trades">Back</a>