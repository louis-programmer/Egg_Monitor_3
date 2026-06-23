@extends('layouts.app')

@section('content')

<h1>Order #{{ $order->id }}</h1>

<div style="margin-bottom: 20px;">
    <strong>Current Day:</strong> {{ $order->current_day }} <br>
    <strong>Status:</strong> {{ $order->simulation_status ?? 'pending' }}
</div>

<hr>

<h3>Controls</h3>

<a href="/orders/{{ $order->id }}/start">▶ Start</a> |
<a href="/orders/{{ $order->id }}/next-day">⏭ Next Day</a> |
<a href="/orders/{{ $order->id }}/day-18">⏱ Day 18</a> |
<a href="/orders/{{ $order->id }}/day-21">🏁 Finish</a>

<hr>

<h3>Batches</h3>

@foreach($order->batches as $batch)
    <div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
        <strong>Machine:</strong> {{ $batch->machine->machine_name }} <br>
        <strong>Amount:</strong> {{ $batch->batch_amount }} <br>
        <strong>Status:</strong> {{ $batch->status }} <br>
        <strong>Current Day:</strong> {{ $batch->current_day ?? 0 }}
    </div>
@endforeach

@endsection