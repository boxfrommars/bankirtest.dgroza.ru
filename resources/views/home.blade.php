@extends('layouts.app')

@push('scripts')
    <script defer="defer" src="{{ asset('js/fallingbottles.js') }}" type="text/javascript"></script>
@endpush

@section('content')
<div id="wall">
    @foreach ($filledBottles as $filledBottle)
        <div class="filled-bottle on-table">
            <img title="{{ 'этикетка: '.$filledBottle->name.' | напиток: '.$filledBottle->beverage->name }}" src="{{ asset('img/'.$filledBottle->bottle->img_src) }}" alt="{{ $filledBottle->bottle->name }}" />
        </div>
    @endforeach
    <div id="songline"></div>
</div>
<a href="#" class="song-handler" id="sing-song">sing!</a>&nbsp;&nbsp;&nbsp;
<a class="song-handler" href="#" id="stop-song">stop!</a>&nbsp;&nbsp;&nbsp;
<a class="song-handler" href="{{ route('home') }}" id="new-song">once more!</a>
@endsection
