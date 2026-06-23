<h1>Orders</h1>

<a href="{{ route('orders.create') }}">Create Order</a>

@foreach($orders as $order)
    <div>
        Order #{{ $order->id }} -
        Amount: {{ $order->order_amount }} -
        Status: {{ $order->status }}
    </div>
@endforeach