@extends('layouts.app')

@section('content')
<h2>Вы хотите удалить напиток <i>{{ $beverage->name }}?</i></h2>
<form method="post" action="{{ route('beverages.destroy', $beverage) }}">
    @csrf
    <input type="submit" name="submit" value="да, удалить" />
</form>
@endsection
