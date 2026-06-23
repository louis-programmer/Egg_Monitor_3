<h1>Edit Customer</h1>

<form method="POST" action="{{ route('customers.update', $customer) }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $customer->name }}">

    <button type="submit">Update</button>
</form>