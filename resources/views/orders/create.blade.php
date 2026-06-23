<h1>Create Order</h1>

<form method="POST" action="{{ route('orders.store') }}">
    @csrf

    <label>Customer</label>
    <select name="customer_id">
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}">
                {{ $customer->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Order Amount</label>
    <input type="number" name="order_amount">

    <br><br>

    <button type="submit">Create Order</button>
</form>