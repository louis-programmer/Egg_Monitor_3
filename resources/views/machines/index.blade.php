<h1>Machines</h1>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Brand</th>
            <th>Status</th>
            <th>Active</th>
            <th>Max Load</th>
            <th>Min Load</th>
            <th>Available On</th>
        </tr>
    </thead>

    <tbody>
        @foreach($machines as $machine)
            <tr>
                <td>{{ $machine->id }}</td>
                <td>{{ $machine->machine_name }}</td>
                <td>{{ ucfirst($machine->machine_type) }}</td>
                <td>{{ ucfirst($machine->brand) }}</td>
                <td>{{ ucfirst($machine->status) }}</td>
                <td>
                    {{ $machine->is_active ? 'Yes' : 'No' }}
                </td>
                <td>{{ number_format($machine->maximum_load) }}</td>
                <td>{{ number_format($machine->minimum_load) }}</td>
                <td>
                    {{ $machine->available_on ?? '-' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>