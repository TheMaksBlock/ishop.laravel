@php
    $parent = isset($category->childs);
    $id = $category->id;
    $delete = $parent ? '<i class="fa fa-fw fa-close"></i>' : '<a href="' . route('admin.category.delete', ['id' => $id]) . '" class="delete"><i class="fa fa-fw fa-close text-danger"></i></a>';
@endphp

<p class="item-p">
    <a class="list-group-item" href="{{ route('admin.category.edit', ['category' => $id]) }}">{{ $category->title }}</a>
    <span>{!! $delete !!}</span>
</p>

@if ($parent)
    <div class="list-group">
        @foreach($category->childs as $child)
            @include('templates.adminCategoriesMenu_tpl', ['category' => $child])
        @endforeach

    </div>
@endif

