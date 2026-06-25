@extends('layouts.app')

@section('content')

<style>

body{
    background:#343a40;
}
.dashboard-header{
    margin-bottom:25px;
}

.dashboard-header h1{
    margin:0;
    font-size:28px;
     color:#ced4da;
}

.dashboard-header p{
    margin-top:5px;
     color:#ced4da;
}

.section-title{
    margin-top:35px;
    margin-bottom:20px;
    font-size:22px;
  color:white;
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

.legend-item{
    color:#f1f3f5;
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


@keyframes activePulse {
    0%   { transform: translateY(0px); }
    50%  { transform: translateY(-2px); }
    100% { transform: translateY(0px); }
}

.machine-running {
    animation: activePulse 2s infinite ease-in-out;
}




.modal-overlay{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.75);
    z-index:9999;

    justify-content:center;
    align-items:center;
}

.modal-card{
    width:700px;
    max-width:90%;
    background:#2b3035;
    color:white;
    border-radius:16px;
    padding:25px;
    box-shadow:0 15px 40px rgba(0,0,0,.4);
    animation:modalPop .2s ease;
}

@keyframes modalPop{
    from{
        transform:scale(.95);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

.modal-close{
    float:right;
    cursor:pointer;
    font-size:24px;
    font-weight:bold;
}

.modal-grid{
    display:grid;
    grid-template-columns:220px 1fr;
    gap:25px;
    margin-top:15px;
}

.modal-image{
    width:200px;
    height:200px;
    object-fit:contain;
}

.modal-title{
    font-size:26px;
    font-weight:bold;
    margin-bottom:10px;
}

.modal-label{
    color:#adb5bd;
    font-size:13px;
}

.modal-value{
    margin-bottom:10px;
}

.modal-bar{
    background:#495057;
    height:18px;
    border-radius:20px;
    overflow:hidden;
}

.modal-bar-fill{
    background:#2ecc71;
    height:100%;
}

.customer-badge{
    display:inline-block;
    padding:4px 10px;
    border-radius:20px;
    color:white;
    font-size:12px;
    font-weight:bold;
}


</style>

<div class="dashboard-header">
    <h1>Egg Monitor Dashboard</h1>
    <p>Machine Monitoring Overview</p>
</div>

<div style="
    text-align:right;
    color:white;
    margin-bottom:20px;
    font-size:18px;
    font-weight:bold;
">
    <span id="clock"></span>
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


<div class="summary-card">
    <div class="summary-card-title">
        Active Machines
    </div>

    <div class="summary-card-value">
        {{
            $setters->where('is_vacant', false)->count()
            +
            $hatchers->where('is_vacant', false)->count()
        }}
    </div>
</div>

<div class="summary-card">
    <div class="summary-card-title">
        Utilization
    </div>

            <div class="summary-card-value">
                {{
                    round(
                        (
                            (
                                $setters->where('is_vacant', false)->count()
                                +
                                $hatchers->where('is_vacant', false)->count()
                            )
                            /
                            (
                                $setters->count()
                                +
                                $hatchers->count()
                            )
                        ) * 100
                    )
                }}%
            </div>
          </div>

          <div class="summary-card">

                <div class="summary-card-title">
                    Setter Utilization
                </div>

                <div class="summary-card-value">

                    {{
                        round(
                            (
                                $setters->where('is_vacant', false)->count()
                                /
                                max($setters->count(),1)
                            ) * 100
                        )
                    }}%

                </div>

            </div>


</div>

<h3 style="color:white;">
    Machine Occupancy
</h3>

<div style="
    background:#495057;
    height:25px;
    border-radius:20px;
    overflow:hidden;
    margin-bottom:25px;
">

    <div style="
        width:
        {{
            round(
                (
                    (
                        $setters->where('is_vacant', false)->count()
                        +
                        $hatchers->where('is_vacant', false)->count()
                    )
                    /
                    (
                        $setters->count()
                        +
                        $hatchers->count()
                    )
                ) * 100
            )
        }}%;
        height:100%;
        background:#2ecc71;
    ">
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

$batchId = '-';
$orderId = '-';
$eggsLoaded = 0;
$currentDay = 0;

if (!$machine->is_vacant && $machine->batches->count()) {

    $batch = $machine->batches->last();

    if ($batch->order && $batch->order->customer) {

        $customerColor = $batch->order->customer->color_code ?? '#cccccc';
        $customerName = $batch->order->customer->name;
    }

    $batchId = $batch->id;
    $orderId = $batch->order_id;
    $eggsLoaded = $batch->batch_amount;
    $currentDay = $batch->current_day ?? 0;
}

$capacity = $machine->maximum_load ?? 0;

$image = str_contains(strtolower($machine->brand), 'jamesway')
    ? 'images/machines/jamesway setter.jpeg'
    : 'images/machines/solera setter.jpg';

@endphp

<div
class="machine-link"
style="cursor:pointer;"
onclick="openMachineModal(
'{{ $machine->machine_name }}',
'Setter',
'{{ $customerName ?: 'Vacant' }}',
'{{ $machine->status ?? 'Standby' }}',
'{{ $batchId }}',
'{{ $orderId }}',
'{{ $eggsLoaded }}',
'{{ $currentDay }}',
'{{ $capacity }}',
'{{ $customerColor }}',
'{{ asset($image) }}'
)">

<div class="machine-card
@if(!$machine->is_vacant)
    machine-running
@endif
"

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

</div>

@endforeach

</div>

<h2 class="section-title">Hatcher Machines</h2>

<div class="machine-grid">

@foreach($hatchers as $machine)

@php

$customerColor = '#cccccc';
$customerName = '';

$batchId = '-';
$orderId = '-';
$eggsLoaded = 0;
$currentDay = 0;

if (!$machine->is_vacant && $machine->batches->count()) {

    $batch = $machine->batches->last();

    if ($batch->order && $batch->order->customer) {

        $customerColor = $batch->order->customer->color_code ?? '#cccccc';
        $customerName = $batch->order->customer->name;
    }

    $batchId = $batch->id;
    $orderId = $batch->order_id;
    $eggsLoaded = $batch->batch_amount;
    $currentDay = $batch->current_day ?? 0;
}

$capacity = $machine->maximum_load ?? 0;

$image = str_contains(strtolower($machine->brand), 'jamesway')
    ? 'images/machines/jamesway hatcher.jpeg'
    : 'images/machines/solera hatcher.jpg';

@endphp

<div
class="machine-link"
style="cursor:pointer;"
onclick="openMachineModal(
'{{ $machine->machine_name }}',
'Setter',
'{{ $customerName ?: 'Vacant' }}',
'{{ $machine->status ?? 'Standby' }}',
'{{ $batchId }}',
'{{ $orderId }}',
'{{ $eggsLoaded }}',
'{{ $currentDay }}',
'{{ $capacity }}',
'{{ $customerColor }}',
'{{ asset($image) }}'
)">

<div class="machine-card hatcher-card
@if(!$machine->is_vacant)
    machine-running
@endif
"
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

</div>

@endforeach

</div>


<script>

function openMachineModal(
    machineName,
    machineType,
    customerName,
    status,
    batchId,
    orderId,
    eggsLoaded,
    currentDay,
    capacity,
    customerColor,
    image
){

    let loadPercent = 0;

    if(capacity > 0){
        loadPercent = Math.round(
            (eggsLoaded / capacity) * 100
        );
    }

    document.getElementById('modalMachineName').innerText = machineName;

    document.getElementById('modalType').innerText = machineType;

    document.getElementById('modalStatus').innerText = status;

    document.getElementById('modalOrder').innerText = orderId;

    document.getElementById('modalBatch').innerText = batchId;

    document.getElementById('modalEggs').innerText = eggsLoaded;

    document.getElementById('modalDay').innerText = currentDay;

    document.getElementById('modalCustomerBadge').innerText = customerName;

    document.getElementById('modalCustomerBadge').style.backgroundColor =
        customerColor;

    document.getElementById('modalCapacityBar').style.width =
        loadPercent + '%';

    document.getElementById('modalCapacityText').innerText =
        loadPercent + '% Utilized';

    document.getElementById('machineModal').style.display = 'flex';

    document.getElementById('modalImage').src = image;
}

function closeMachineModal()
{
    document.getElementById('machineModal').style.display='none';
}

</script>



<div id="machineModal" class="modal-overlay" onclick="closeMachineModal()">

    <div class="modal-card" onclick="event.stopPropagation()">

        <span class="modal-close"
              onclick="closeMachineModal()">
            ×
        </span>

        <div class="modal-title" id="modalMachineName">
            Machine
        </div>

        <div class="modal-grid">

            <div>

                <img
                    id="modalImage"
                    src=""
                    class="modal-image"
                >

            </div>

            <div>

                <div class="modal-label">Customer</div>
                <div class="modal-value">
                    <span id="modalCustomerBadge"
                          class="customer-badge">
                    </span>
                </div>

                <div class="modal-label">Brand</div>
                <div class="modal-value" id="modalBrand"></div>

                <div class="modal-label">Machine Type</div>
                <div class="modal-value" id="modalType"></div>

                <div class="modal-label">Status</div>
                <div class="modal-value" id="modalStatus"></div>

                <div class="modal-label">Order ID</div>
                <div class="modal-value" id="modalOrder"></div>

                <div class="modal-label">Batch ID</div>
                <div class="modal-value" id="modalBatch"></div>

                <div class="modal-label">Egg Count</div>
                <div class="modal-value" id="modalEggs"></div>

                <div class="modal-label">Current Day</div>
                <div class="modal-value" id="modalDay"></div>

                <div class="modal-label">Phase</div>
                <div class="modal-value" id="modalPhase"></div>

                <div style="margin-top:20px;">
                    Capacity Utilization
                </div>

                <div class="modal-bar">
                    <div id="modalCapacityBar"
                         class="modal-bar-fill">
                    </div>
                </div>

                <div id="modalCapacityText"
                     style="margin-top:5px;">
                </div>

            </div>

        </div>

    </div>

</div>





<script>

function updateClock() {

    const now = new Date();

    document.getElementById('clock').innerHTML =
        now.toLocaleString();

}

setInterval(updateClock, 1000);

updateClock();

</script>


@endsection


