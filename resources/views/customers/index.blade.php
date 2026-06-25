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

.btn-primary:hover{
    opacity:.9;
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
    text-align:left;
    padding:14px;
    background:#f4f6f8;
    font-size:14px;
}

.table td{
    padding:14px;
    border-top:1px solid #eee;
}

.table tr:hover{
    background:#fafafa;
}

.customer-color{
    width:24px;
    height:24px;
    border-radius:50%;
    border:2px solid #ddd;
}

.action-btn{
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    margin-right:5px;
}

.edit-btn{
    background:#3498db;
    color:white;
}

.delete-btn{
    background:#e74c3c;
    color:white;
    border:none;
    cursor:pointer;
}

.success-message{
    background:#dff0d8;
    color:#3c763d;
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;
}

.summary-card{
    background:white;
    border-radius:16px;
    padding:20px;
    margin-bottom:20px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.summary-title{
    color:#777;
    font-size:13px;
}

.summary-value{
    font-size:32px;
    font-weight:bold;
    margin-top:8px;
}

</style>

<div class="page-header">

    <div>
        <h1 class="page-title">Customers</h1>
        <div class="page-subtitle">
            Manage hatchery customers
        </div>
    </div>

    <a href="{{ route('customers.create') }}" class="btn-primary">
        + Add Customer
    </a>

</div>

@if(session('success'))

    <div class="success-message">
        {{ session('success') }}
    </div>

@endif

<div class="summary-card">

    <div class="summary-title">
        Total Customers
    </div>

    <div class="summary-value">
        {{ $customers->count() }}
    </div>

</div>

<div class="card">

    <table class="table">

        <thead>

            <tr>
                <th>ID</th>
                <th>Color</th>
                <th>Customer Name</th>
                <th>Actions</th>
            </tr>

        </thead>

        <tbody>

        @forelse($customers as $customer)

            <tr>

                <td>
                    {{ $customer->id }}
                </td>

                <td>

                    <div
                        class="customer-color"
                        style="background: {{ $customer->color_code ?? '#cccccc' }};">
                    </div>

                </td>

                <td>
                    {{ $customer->name }}
                </td>

                <td>

                    <a
                        href="{{ route('customers.edit', $customer) }}"
                        class="action-btn edit-btn">
                        Edit
                    </a>

                    <form
                        action="{{ route('customers.destroy', $customer) }}"
                        method="POST"
                        style="display:inline;">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="action-btn delete-btn"
                            onclick="return confirm('Delete this customer?')">

                            Delete

                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="4" style="text-align:center;">

                    No customers found.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection