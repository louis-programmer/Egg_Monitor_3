<h1>Create Customer</h1>

<form method="POST" action="{{ route('customers.store') }}">
    @csrf

    <input type="text" name="name" placeholder="Customer Name">

    <button type="submit">Save</button>
</form>