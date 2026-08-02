<form enctype="application/x-www-form-urlencoded" method="post" action="{{ $action }}">
    @csrf
    <dl class="zend_form">
        <dt><label for="name" class="required">beverage's name:</label></dt>
        <dd>
            <input type="text" name="name" id="name" value="{{ old('name', $beverage->name ?? '') }}" />
            @include('partials.field-errors', ['field' => 'name'])
        </dd>
        <dt><label for="description" class="required">description of the beverage:</label></dt>
        <dd>
            <textarea name="description" id="description">{{ old('description', $beverage->description ?? '') }}</textarea>
            @include('partials.field-errors', ['field' => 'description'])
        </dd>
        <dt>&nbsp;</dt>
        <dd><input type="submit" name="submit" id="submit" value="сохранить" /></dd>
    </dl>
</form>
