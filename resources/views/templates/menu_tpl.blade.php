@php
    $parent = isset($category->childs);
@endphp
<li>
    <a href="{{ url('category/' . $category->alias) }}">{{ $category->title }}</a>
    @if($parent)
        <ul>
            @foreach($category->childs as $child)
                @include('templates.menu_tpl', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>
