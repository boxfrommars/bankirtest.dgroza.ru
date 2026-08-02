@extends('layouts.app')

@section('content')
<h2>Edit beverage <i>{{ $beverage->name }}</i></h2>
<a href="{{ route('beverages.show', $beverage) }}">вернуться к просмотру</a>
@include('partials.beverage-form', ['action' => route('beverages.update', $beverage), 'beverage' => $beverage])
@endsection
