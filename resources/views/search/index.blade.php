@extends('layouts.app')

@section('content')
@include('partials.search-form', ['suffix' => '-results'])

@if ($searchString !== null)
    <h2>Результаты поиска по фразе <i>{{ $searchString }}</i></h2>
    @if ($searchResult->isNotEmpty())
        <ul>
            @foreach ($searchResult as $hit)
                <li><a href="{{ route('beverages.show', $hit) }}">{{ $hit->name }}</a></li>
            @endforeach
        </ul>
    @else
        соответствий не найдено
    @endif
@endif
@endsection
