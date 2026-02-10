<h1>Hardware create</h1>


<form action="{{ route('hardware.store') }}" method="post">
    @csrf

    <label for="name">name</label>
    <input type="text" name="name" id="name">

    <label for="total">total</label>
    <input type="text" name="total" id="total">

    <label for="price">price</label>
    <textarea name="price" id="price"></textarea>

    <button type="submit">Hardware create</button>

</form>