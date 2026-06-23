@extends('layouts.app')

@section('content')

<h2>Setter Machines</h2>

<div class="machine-grid">

@foreach($setters as $machine)

<a href="{{ route('machine.show', $machine->id) }}" style="text-decoration:none;">
    <div class="machine-card
        @if(!$machine->is_active)
            inactive
        @elseif(!$machine->is_vacant)
            occupied
        @else
            vacant
        @endif
    ">
        {{ $machine->machine_name }}
    </div>
</a>

@endforeach

</div>

<hr>

<h2>Hatcher Machines</h2>

<div class="machine-grid">

@foreach($hatchers as $machine)
<a href="{{ route('machine.show', $machine->id) }}" style="text-decoration:none;">
    <div class="machine-card
        @if(!$machine->is_active)
            inactive
        @elseif(!$machine->is_vacant)
            occupied
        @else
            vacant
        @endif
    ">
        {{ $machine->machine_name }}
    </div>
</a>


@endforeach

</div>

@endsection