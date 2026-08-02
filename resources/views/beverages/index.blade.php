@extends('layouts.app')

@section('content')
<h2>Beverages:</h2>
<div class="block">
    <ul>
        @foreach ($entries as $entry)
            <li><a href="{{ route('beverages.show', $entry) }}">{{ $entry->name }}</a></li>
        @endforeach
    </ul>
</div>

<a href="#" id="toggle-add-beverage-block" class="toggle-block-link">Add beverage</a>
<div class="block" id="add-beverage-block">
    <h2>Add beverage</h2>
    <p>Please use the form below to add beverages to the database!</p>
    @include('partials.beverage-form', ['action' => route('beverages.store')])
</div>
@endsection
