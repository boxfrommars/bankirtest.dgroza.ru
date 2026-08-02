@php($suffix = $suffix ?? '')
<form enctype="application/x-www-form-urlencoded" method="post" action="{{ route('search') }}">
    @csrf
    <dl class="zend_form">
        <dt><label for="searchstring{{ $suffix }}" class="required">Search</label></dt>
        <dd><input type="text" name="searchstring" id="searchstring{{ $suffix }}" value="{{ old('searchstring', $searchString ?? '') }}" /></dd>
        <dt>&nbsp;</dt>
        <dd><input type="submit" name="submit" id="submit{{ $suffix }}" value="Search" /></dd>
    </dl>
</form>
