@if ($errors->has($field))
    <ul class="errors">
        @foreach ($errors->get($field) as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
