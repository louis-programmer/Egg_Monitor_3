@extends('layouts.app')

@section('content')

<style>

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.page-title{
    margin:0;
    font-size:28px;
}

.page-subtitle{
    color:#666;
    margin-top:5px;
}

.btn-primary{
    background:#2c7be5;
    color:white;
    padding:10px 16px;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
}

.summary-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
    margin-bottom:25px;
}

.summary-card{
    background:white;
    padding:20px;
    border-radius:16px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.summary-title{
    color:#777;
    font-size:13px;
}

.summary-value{
    font-size:30px;
    font-weight:bold;
    margin-top:10px;
}

.card{
    background:white;
    border-radius:16px;
    padding:20px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table th{
    background:#f4f6f8;
    padding:14px;
    text-align:left;
}

.table td{
    padding:14px;
    border-top:1px solid #eee;
}

.table tr:hover{
    background:#fafafa;
}

.status-badge{
    display:inline-block;
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.status-pending{
    background:#ffeaa7;
}

.status-running{
    background:#74b9ff;
    color:white;
}

.status-paused{
    background:#fdcb6e;
}

.status-completed{
    background:#55efc4;
}

.view-btn{
    background:#2c7be5;
    color:white;
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
    font-size:13px;
}

</style>

<div class="page-header">

    <div>
        <h1 class="page-title">Orders</h1>
        <div class="page-subtitle">
            Hatchery production orders
        </div>
    </div>

    <a href="{{ route('orders.create') }}" class="btn-primary">
        + Create Order
    </a>

</div>

<div class="summary-grid">

    <div class="summary-card">
        <div class="summary-title">Total Orders</div>
        <div class="summary-value">
            {{ $orders->count() }}
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-title">Running Orders</div>
        <div class="summary-value">
            {{ $orders->where('simulation_status','running')->count() }}
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-title">Paused Orders</div>
        <div class="summary-value">
            {{ $orders->where('simulation_status','paused')->count() }}
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-title">Completed Orders</div>
        <div class="summary-value">
            {{ $orders->where('simulation_status','completed')->count() }}
        </div>
    </div>

</div>

<div class="card">

    <table class="table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Order Amount</th>
                <th>Total Eggs</th>
                <th>Day</th>
                <th>Status</th>
                <th>Phase</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        @forelse($orders as $order)

            <tr>

                <td>
                    #{{ $order->id }}
                </td>

                <td>
                    {{ $order->customer->name ?? 'N/A' }}
                </td>

                <td>
                    {{ number_format($order->order_amount) }}
                </td>

                <td>
                    {{ number_format($order->total_eggs) }}
                </td>

                <td>
                    {{ $order->current_day ?? 0 }}
                </td>

                <td>

                    <span class="status-badge
                        @if(($order->simulation_status ?? 'pending') == 'running')
                            status-running
                        @elseif(($order->simulation_status ?? 'pending') == 'paused')
                            status-paused
                        @elseif(($order->simulation_status ?? 'pending') == 'completed')
                            status-completed
                        @else
                            status-pending
                        @endif
                    ">
                        {{ ucfirst($order->simulation_status ?? 'pending') }}
                    </span>

                </td>

                <td>
                    {{ ucfirst($order->state ?? 'setter') }}
                </td>

                <td>

                    <a
                        href="{{ route('orders.show', $order->id) }}"
                        class="view-btn">
                        View
                    </a>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="8" style="text-align:center;">
                    No orders found.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection