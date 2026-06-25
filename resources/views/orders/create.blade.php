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

.form-card{
    background:white;
    border-radius:16px;
    padding:25px;
    max-width:800px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.form-group{
    margin-bottom:20px;
}

.form-label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
}

.form-input,
.form-select{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
    font-size:14px;
    box-sizing:border-box;
}

.form-input:focus,
.form-select:focus{
    outline:none;
    border-color:#2c7be5;
}

.info-box{
    background:#f8f9fa;
    border-left:4px solid #2c7be5;
    padding:15px;
    border-radius:8px;
    margin-bottom:20px;
}

.info-title{
    font-weight:bold;
    margin-bottom:5px;
}

.info-value{
    color:#555;
}

.form-actions{
    margin-top:25px;
    display:flex;
    gap:10px;
}

.btn-primary{
    background:#2c7be5;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
}

.btn-secondary{
    background:#6c757d;
    color:white;
    text-decoration:none;
    padding:12px 20px;
    border-radius:8px;
}

.validation-error{
    color:#e74c3c;
    margin-top:5px;
    font-size:13px;
}

</style>

<div class="page-header">

    <h1 class="page-title">
        Create Order
    </h1>

    <div class="page-subtitle">
        Create a new hatchery production order
    </div>

</div>

<div class="form-card">

    <div class="info-box">

        <div class="info-title">
            Current System Settings
        </div>

        <div class="info-value">
            Order Buffer:
            <strong>{{ $settings->preset_order_buffer ?? 0 }}%</strong>
        </div>

        <div class="info-value">
            Setter Survival Rate:
            <strong>{{ $settings->preset_setter_survival_rate ?? 0 }}%</strong>
        </div>

        <div class="info-value">
            Hatcher Survival Rate:
            <strong>{{ $settings->preset_hatcher_survival_rate ?? 0 }}%</strong>
        </div>

    </div>

    <form method="POST" action="{{ route('orders.store') }}">

        @csrf

        <div class="form-group">

            <label class="form-label">
                Customer
            </label>

            <select
                name="customer_id"
                class="form-select"
                required>

                <option value="">
                    Select Customer
                </option>

                @foreach($customers as $customer)

                    <option
                        value="{{ $customer->id }}"
                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>

                        {{ $customer->name }}

                    </option>

                @endforeach

            </select>

            @error('customer_id')
                <div class="validation-error">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div class="form-group">

            <label class="form-label">
                Order Amount
            </label>

            <input
                type="number"
                name="order_amount"
                class="form-input"
                value="{{ old('order_amount') }}"
                min="1"
                placeholder="Enter number of eggs"
                required>

            @error('order_amount')
                <div class="validation-error">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div class="form-actions">

            <button type="submit" class="btn-primary">
                Create Order
            </button>

            <a href="{{ route('orders.index') }}" class="btn-secondary">
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection