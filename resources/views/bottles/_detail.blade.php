<h2><a href="{{ route('bottles.index') }}">bottles</a> / {{ $bottle->name }}</h2>
<img src="{{ asset('img/'.$bottle->img_src) }}" alt="{{ $bottle->name }}" />
<div class="description">
    {{ $bottle->description }}
</div>
