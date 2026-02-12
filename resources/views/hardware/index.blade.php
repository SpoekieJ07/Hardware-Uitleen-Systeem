<!DOCTYPE html>
<html>
    
<head>
    <title>Hardware List</title>
    <button><a href="{{ route('hardware.create') }}">Create New Hardware</a></button>
    <h1>Hardware List</h1>
    
    <ul>
        @foreach ($hardwares as $hardware)
            <li>
                <h2>name: {{ $hardware->name }}</h2>
                <p>total: {{ $hardware->total}}</p>
                <p>price: {{ $hardware->price}}</p>
                <form action="{{ route('hardware.edit', $hardware->id) }}" method="get">
                    @csrf
                    @method('PUT')
                    <button type="submit">Edit Hardware</button>
                </form>
                <form action="{{route('hardware.destroy', $hardware->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete Hardware</button>
                </form>
            </li>
        @endforeach
    </ul>
    