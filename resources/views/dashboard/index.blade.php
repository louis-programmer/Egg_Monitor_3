@extends('layouts.app')

@section('content')

<style>

body{
    background:#f1f3f5;
}

.dashboard-header{
    margin-bottom:25px;
}

.dashboard-header h1{
    margin:0;
    font-size:28px;
}

.dashboard-header p{
    margin-top:5px;
    color:#666;
}

.section-title{
    margin-top:35px;
    margin-bottom:20px;
    font-size:22px;
    color:#333;
}

.machine-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(110px,1fr));
    gap:28px;
}

.machine-card{
    background:#fff;
    border:4px solid #ccc;
    border-radius:12px;
    height:140px;
    padding:8px;
    position:relative;
    text-align:center;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
    transition:all .2s ease;
}

.hatcher-card{
    background:#262626;
    color:white;
}

.hatcher-card .machine-number{
    color:white;
}

.hatcher-card .customer-name{
    color:#e0e0e0;
}

.machine-card:hover{
    transform:translateY(-3px);
    box-shadow:0 5px 15px rgba(0,0,0,.12);
}

.machine-image{
    width:65px;
    height:65px;
    object-fit:contain;
    margin-top:5px;
}

.machine-number{
    font-size:13px;
    font-weight:bold;
    margin-top:5px;
    color:#333;
}

.customer-name{
    font-size:11px;
    font-weight:600;
    margin-top:4px;
    color:#555;
}

.machine-status{
    font-size:10px;
    color:#777;
    margin-top:3px;
}

.machine-link{
    text-decoration:none;
}

.status-dot{
    width:12px;
    height:12px;
    border-radius:50%;
    position:absolute;
    bottom:8px;
    right:8px;
    border:1px solid #fff;
}

.vacant-dot{
    background:#2ecc71;
}

.running-dot{
    background:#f39c12;
}

.inactive-dot{
    background:#e74c3c;
}

.waiting-transfer-dot{
    background:#3498db;
}

.legend{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
    margin-bottom:20px;
}

.legend-item{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:13px;
}

.legend-dot{
    width:14px;
    height:14px;
    border-radius:50%;
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
    border-radius:14px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.summary-card-title{
    font-size:13px;
    color:#777;
}

.summary-card-value{
    font-size:28px;
    font-weight:bold;
    margin-top:8px;
}

</style>

<div class="dashboard-header">
    <h1>Egg Monitor Dashboard</h1>
    <p>Machine Monitoring Overview</p>
</div>

<div class="summary-grid">

    <div class="summary-card">
        <div class="summary-card-title">Total Setters</div>
        <div class="summary-card-value">{{ $setters->count() }}</div>
    </div>

    <div class="summary-card">
        <div class="summary-card-title">Total Hatchers</div>
        <div class="summary-card-value">{{ $hatchers->count() }}</div>
    </div>

    <div class="summary-card">
        <div class="summary-card-title">Occupied Machines</div>
        <div class="summary-card-value">
            {{ $setters->where('is_vacant', false)->count() + $hatchers->where('is_vacant', false)->count() }}
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-card-title">Vacant Machines</div>
        <div class="summary-card-value">
            {{ $setters->where('is_vacant', true)->count() + $hatchers->where('is_vacant', true)->count() }}
        </div>
    </div>

</div>

<div class="legend">

    <div class="legend-item">
        <div class="legend-dot vacant-dot"></div>
        Vacant
    </div>

    <div class="legend-item">
        <div class="legend-dot running-dot"></div>
        Running
    </div>

    <div class="legend-item">
        <div class="legend-dot waiting-transfer-dot"></div>
        Waiting Transfer
    </div>

    <div class="legend-item">
        <div class="legend-dot inactive-dot"></div>
        Inactive
    </div>

</div>

<h2 class="section-title">Setter Machines</h2>

<div class="machine-grid">

@foreach($setters as $machine)

@php

    $customerColor = '#cccccc';
    $customerName = '';

    if (!$machine->is_vacant && $machine->batches->count()) {

        $batch = $machine->batches->last();

        if ($batch->order && $batch->order->customer) {

            $customerColor = $batch->order->customer->color_code ?? '#cccccc';
            $customerName = $batch->order->customer->name;
        }
    }

    $image = str_contains(strtolower($machine->brand), 'jamesway')
        ? 'images/machines/jamesway setter.jpeg'
        : 'images/machines/solera setter.jpg';

@endphp

<a href="{{ route('machine.show', $machine->id) }}" class="machine-link">

<div class="machine-card"
style="border-color: {{ !$machine->is_vacant ? $customerColor : '#cccccc' }};">

    @if(!$machine->is_active)
        <div class="status-dot inactive-dot"></div>
    @elseif($machine->status == 'waiting_transfer')
        <div class="status-dot waiting-transfer-dot"></div>
    @elseif(!$machine->is_vacant)
        <div class="status-dot running-dot"></div>
    @else
        <div class="status-dot vacant-dot"></div>
    @endif

    <img src="{{ asset($image) }}" class="machine-image">

    <div class="machine-number">
        {{ $machine->machine_name }}
    </div>

    @if(!$machine->is_vacant)
        <div class="customer-name">
            {{ $customerName }}
        </div>
    @endif

</div>

</a>

@endforeach

</div>

<h2 class="section-title">Hatcher Machines</h2>

<div class="machine-grid">

@foreach($hatchers as $machine)

@php

    $customerColor = '#cccccc';
    $customerName = '';

    if (!$machine->is_vacant && $machine->batches->count()) {

        $batch = $machine->batches->last();

        if ($batch->order && $batch->order->customer) {

            $customerColor = $batch->order->customer->color_code ?? '#cccccc';
            $customerName = $batch->order->customer->name;
        }
    }

    $image = str_contains(strtolower($machine->brand), 'jamesway')
        ? 'images/machines/jamesway hatcher.jpeg'
        : 'images/machines/solera hatcher.jpg';

@endphp

<a href="{{ route('machine.show', $machine->id) }}" class="machine-link">

<div class="machine-card hatcher-card"
style="border-color: {{ !$machine->is_vacant ? $customerColor : '#cccccc' }};">

    @if(!$machine->is_active)
        <div class="status-dot inactive-dot"></div>
    @elseif($machine->status == 'waiting_transfer')
        <div class="status-dot waiting-transfer-dot"></div>
    @elseif(!$machine->is_vacant)
        <div class="status-dot running-dot"></div>
    @else
        <div class="status-dot vacant-dot"></div>
    @endif

    <img src="{{ asset($image) }}" class="machine-image">

    <div class="machine-number">
        {{ $machine->machine_name }}
    </div>

    @if(!$machine->is_vacant)
        <div class="customer-name">
            {{ $customerName }}
        </div>
    @endif

</div>

</a>

@endforeach

</div>

@endsection