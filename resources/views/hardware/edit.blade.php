<h1>hardware edit</h1>
    <form action="{{ route('hardware.update', $hardware->id) }}" method="post">
        @csrf
        @method('PUT')
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $hardware->name }}">
        <label for="address">total</label>
        <textarea name="total" id="total">{{ $hardware->total }}</textarea>
        <label for="description">price</label>
        <textarea name="price" id="price">{{ $hardware->price }}</textarea>
        
        
        </select>
        <button type="submit">hardware edit</button>

    </form>