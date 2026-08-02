@extends('layouts.app')

@section('content')
<h2>Bottles:</h2>
<div class="block">
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bottles as $entry)
                <tr>
                    <td><img src="{{ asset('img/'.$entry->img_src) }}" alt="{{ $entry->name }}" /></td>
                    <td><a href="{{ route('bottles.show', $entry) }}">{{ $entry->name }}</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
