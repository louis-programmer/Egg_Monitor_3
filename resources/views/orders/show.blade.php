@extends('layouts.app')

@section('content')

<style>

.page-header{
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
    font-size:24px;
    font-weight:bold;
    margin-top:10px;
}

.control-card{
    background:white;
    padding:20px;
    border-radius:16px;
    margin-bottom:25px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.control-buttons{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
}

.btn{
    padding:10px 16px;
    border-radius:8px;
    text-decoration:none;
    color:white;
    font-weight:600;
}

.btn-start{
    background:#27ae60;
}

.btn-next{
    background:#3498db;
}

.btn-day18{
    background:#f39c12;
}

.btn-finish{
    background:#e74c3c;
}

.batch-card{
    background:white;
    border-radius:16px;
    padding:18px;
    margin-bottom:15px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.batch-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:10px;
}

.batch-label{
    color:#777;
    font-size:12px;
}

.batch-value{
    font-weight:bold;
    margin-top:4px;
}

.transfer-btn{
    margin-top:15px;
    background:#f39c12;
    color:white;
    border:none;
    border-radius:8px;
    padding:10px 14px;
    cursor:pointer;
    font-weight:600;
}

.status-badge{
    display:inline-block;
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
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

.status-pending{
    background:#dfe6e9;
}

.section-title{
    margin-bottom:15px;
}

</style>

<div class="page-header">

    <h1 class="page-title">
        Order #{{ $order->id }}
    </h1>

    <div class="page-subtitle">
        Customer:
        <strong>{{ $order->customer->name ?? 'N/A' }}</strong>
    </div>

</div>

<div class="summary-grid">

    <div class="summary-card">
        <div class="summary-title">Current Day</div>
        <div class="summary-value">
            {{ $order->current_day ?? 0 }}
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-title">Phase</div>
        <div class="summary-value">
            {{ ucfirst($order->state ?? 'setter') }}
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-title">Status</div>
        <div class="summary-value">

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

        </div>
    </div>

    <div class="summary-card">
        <div class="summary-title">Total Eggs</div>
        <div class="summary-value">
            {{ number_format($order->total_eggs) }}
        </div>
    </div>

</div>

<div class="control-card">

    <h3>Simulation Controls</h3>

    <div class="control-buttons">

        <a href="/orders/{{ $order->id }}/start" class="btn btn-start">
            ▶ Start
        </a>

        <a href="/orders/{{ $order->id }}/next-day" class="btn btn-next">
            ⏭ Next Day
        </a>

        <a href="/orders/{{ $order->id }}/day-18" class="btn btn-day18">
            ⏱ Day 18
        </a>

        <a href="/orders/{{ $order->id }}/day-21" class="btn btn-finish">
            🏁 Finish
        </a>

    </div>

</div>

<h2 class="section-title">
    Batches
</h2>

@foreach($order->batches as $batch)

<div class="batch-card">

    <div class="batch-grid">

        <div>
            <div class="batch-label">Batch ID</div>
            <div class="batch-value">
                {{ $batch->id }}
            </div>
        </div>

        <div>
            <div class="batch-label">Machine</div>
            <div class="batch-value">
                {{ $batch->machine->machine_name ?? 'Unassigned' }}
            </div>
        </div>

        <div>
            <div class="batch-label">Machine Type</div>
            <div class="batch-value">
                {{ ucfirst($batch->machine_type) }}
            </div>
        </div>

        <div>
            <div class="batch-label">Phase</div>
            <div class="batch-value">
                {{ ucfirst($batch->phase ?? 'setter') }}
            </div>
        </div>

        <div>
            <div class="batch-label">Egg Count</div>
            <div class="batch-value">
                {{ number_format($batch->batch_amount) }}
            </div>
        </div>

        <div>
            <div class="batch-label">Current Day</div>
            <div class="batch-value">
                {{ $batch->current_day ?? 0 }}
            </div>
        </div>

        <div>
            <div class="batch-label">Status</div>
            <div class="batch-value">
                {{ ucfirst($batch->status) }}
            </div>
        </div>

    </div>

    @if($batch->status === 'paused')

        <form
            method="POST"
            action="{{ route('batches.transfer', $batch->id) }}">

            @csrf

            <button type="submit" class="transfer-btn">
                Transfer To Hatcher
            </button>

        </form>

    @endif

</div>

@endforeach

@endsection