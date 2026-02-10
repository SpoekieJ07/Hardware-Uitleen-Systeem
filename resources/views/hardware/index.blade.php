<!DOCTYPE html>
<html>
    
    <h1>Hardware List</h1>
    
    <ul>
        @foreach ($hardwares as $hardware)
            <li>
                <h2>{{ $hardware->name }}</h2>
                <p>{{ $hardware->address }}</p>
                <p>{{ $hardware->description }}</p>
                <p>{{ $hardware->capacity}}</p>
                <form action="{{ route('hardwares.edit', $hardware->id) }}" method="get">
                    @csrf
                    @method('PUT')
                    <button type="submit">Edit Hardware</button>
                </form>
                <form action="{{route('hardwares.destroy', $hardware->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete Hardware</button>
                </form>
            </li>
        @endforeach
    </ul>
    