<h2><a href="{{ route('beverages.index') }}">beverages</a> / {{ $beverage->name }}</h2>
<div class="description">
    {{ $beverage->description }}
</div>
<ul>
    <li><a href="{{ route('beverages.edit', $beverage) }}">редактировать</a></li>
    <li><a href="{{ route('beverages.delete', $beverage) }}">удалить</a></li>
</ul>
