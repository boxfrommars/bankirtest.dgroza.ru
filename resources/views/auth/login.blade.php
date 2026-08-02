@extends('layouts.app')

@section('content')
<h2>Owner login</h2>
@if ($authenticated)
    <p>Вы вошли как владелец.</p>
    <form method="post" action="{{ route('logout') }}">
        @csrf
        <input type="submit" value="выйти" />
    </form>
@else
    <form method="post" action="{{ route('login.submit') }}">
        @csrf
        <dl class="zend_form">
            <dt><label for="password">password:</label></dt>
            <dd>
                <input type="password" name="password" id="password" />
                @include('partials.field-errors', ['field' => 'password'])
            </dd>
            <dt>&nbsp;</dt>
            <dd><input type="submit" value="войти" /></dd>
        </dl>
    </form>
@endif
@endsection
