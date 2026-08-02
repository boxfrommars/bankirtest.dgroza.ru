@extends('layouts.app')

@section('content')
<h2>Вы хотите удалить напиолненную бутылку <i>{{ $filledBottle->name }}?</i></h2>
<form method="post" action="{{ route('filled-bottles.destroy', $filledBottle) }}">
    @csrf
    <input type="submit" name="submit" value="да, удалить" />
</form>
@endsection
