<!DOCTYPE html>
<html>
    
    <h1>{{ $title }}</h1>
    
    <ul>
        @foreach ($hardwhears as $hardwhear)
            <li>
                <h2>{{ $hardwhear->name }}</h2>
                <p>{{ $hardwhear->address }}</p>
                <p>{{ $hardwhear->description }}</p>
                <p>{{ $hardwhear->capacity}}</p>
                <form action="{{ route('hardwhears.edit', $hardwhear->id) }}" method="get">
                    @csrf
                    @method('PUT')
                    <button type="submit">Edit Hardwear</button>
                </form>
                <form action="{{route('hardwhears.destroy', $hardwhear->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete Hardwear</button>
                </form>
            </li>
        @endforeach
    </ul>
    