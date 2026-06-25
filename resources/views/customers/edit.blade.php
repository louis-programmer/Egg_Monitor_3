<h1>Edit Customer</h1>

<form method="POST" action="{{ route('customers.update', $customer) }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $customer->name }}">


<label>Color</label>

<input
    type="color"
    name="color_code"
    value="{{ old('color_code', $customer->color_code ?? '#3498db') }}"
>


    <button type="submit">Update</button>
</form>