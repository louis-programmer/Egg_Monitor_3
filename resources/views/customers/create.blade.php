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
    max-width:700px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.form-group{
    margin-bottom:20px;
}

.form-label{
    display:block;
    font-weight:600;
    margin-bottom:8px;
}

.form-input{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
    font-size:14px;
    box-sizing:border-box;
}

.color-row{
    display:flex;
    align-items:center;
    gap:15px;
}

.color-preview{
    width:40px;
    height:40px;
    border-radius:50%;
    border:2px solid #ddd;
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
        Create Customer
    </h1>

    <div class="page-subtitle">
        Add a new hatchery customer
    </div>

</div>

<div class="form-card">

    <form method="POST" action="{{ route('customers.store') }}">

        @csrf

        <div class="form-group">

            <label class="form-label">
                Customer Name
            </label>

            <input
                type="text"
                name="name"
                class="form-input"
                value="{{ old('name') }}"
                placeholder="Enter customer name"
                required
            >

            @error('name')
                <div class="validation-error">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div class="form-group">

            <label class="form-label">
                Customer Color
            </label>

            <div class="color-row">

                <input
                    type="color"
                    id="colorPicker"
                    name="color_code"
                    value="{{ old('color_code', '#3498db') }}"
                >

                <div
                    id="colorPreview"
                    class="color-preview"
                    style="background: {{ old('color_code', '#3498db') }};">
                </div>

            </div>

            <small style="color:#666;">
                This color will appear on machine borders in the dashboard.
            </small>

        </div>

        <div class="form-actions">

            <button type="submit" class="btn-primary">
                Save Customer
            </button>

            <a href="{{ route('customers.index') }}" class="btn-secondary">
                Cancel
            </a>

        </div>

    </form>

</div>

<script>

document.getElementById('colorPicker')
    .addEventListener('input', function(){

        document.getElementById('colorPreview')
            .style.background = this.value;

    });

</script>

@endsection