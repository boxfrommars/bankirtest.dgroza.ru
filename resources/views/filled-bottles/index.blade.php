@extends('layouts.app')

@section('content')
<table>
    <tbody>
        @foreach ($filledBottles as $filledBottle)
            <tr>
                <td><b>{{ $filledBottle->name }}</b></td>
                <td>
                    <a class="ajaxify" title="show bottle: {{ $filledBottle->bottle->name }}" href="{{ route('bottles.show', $filledBottle->bottle) }}">
                        <img src="{{ asset('img/'.$filledBottle->bottle->img_src) }}" alt="{{ $filledBottle->bottle->name }}" />
                    </a>
                </td>
                <td><a class="ajaxify" title="show beverage: {{ $filledBottle->beverage->name }}" href="{{ route('beverages.show', $filledBottle->beverage) }}">{{ $filledBottle->beverage->name }}</a></td>
                <td><a href="{{ route('filled-bottles.delete', $filledBottle) }}" title="удалить">X</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="#" id="toggle-add-filledbottle-block" class="toggle-block-link">Add filled bottle</a>
<div class="block" id="add-filledbottle-block">
    <h2>Add filled bottle</h2>
    <p>Please use the form below to add!</p>
    <form enctype="application/x-www-form-urlencoded" method="post" action="{{ route('filled-bottles.store') }}">
        @csrf
        <dl class="zend_form">
            <dt><label for="name" class="required">label:</label></dt>
            <dd>
                <input type="text" name="name" id="name" value="{{ old('name') }}" />
                @include('partials.field-errors', ['field' => 'name'])
            </dd>
            <dt><label for="bottle_id" class="required">bottle:</label></dt>
            <dd>
                <select name="bottle_id" id="bottle_id">
                    @foreach ($bottles as $bottle)
                        <option value="{{ $bottle->id }}" @selected((string) old('bottle_id') === (string) $bottle->id)>{{ $bottle->name }}</option>
                    @endforeach
                </select>
                @include('partials.field-errors', ['field' => 'bottle_id'])
            </dd>
            <dt><label for="beverage_id" class="required">beverage:</label></dt>
            <dd>
                <select name="beverage_id" id="beverage_id">
                    @foreach ($beverages as $beverage)
                        <option value="{{ $beverage->id }}" @selected((string) old('beverage_id') === (string) $beverage->id)>{{ $beverage->name }}</option>
                    @endforeach
                </select>
                @include('partials.field-errors', ['field' => 'beverage_id'])
            </dd>
            <dt>&nbsp;</dt>
            <dd><input type="submit" name="submit" id="submit" value="сохранить" /></dd>
        </dl>
    </form>
</div>
@endsection
