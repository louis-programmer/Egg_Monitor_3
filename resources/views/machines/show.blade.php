@extends('layouts.app')

@section('content')

<h2>Machine: {{ $machine->machine_name }}</h2>

<p>Type: {{ $machine->machine_type }}</p>
<p>Status: {{ $machine->status }}</p>
<p>Vacant: {{ $machine->is_vacant ? 'YES' : 'NO' }}</p>

<hr>

<h3>Current Batch</h3>

@if($currentBatch)
    <p>Batch ID: {{ $currentBatch->id }}</p>
    <p>Order ID: {{ $currentBatch->order_id }}</p>
    <p>Eggs: {{ $currentBatch->batch_amount }}</p>
    <p>Status: {{ $currentBatch->status }}</p>
@else
    <p>No active batch</p>
@endif

@endsection