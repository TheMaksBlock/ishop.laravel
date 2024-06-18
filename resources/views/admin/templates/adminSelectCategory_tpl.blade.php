@php
    if(!isset($tab)){
        $tab = " ";
    }

    if(!isset($currentId)){
        $currentId = null;
    }

    if(!isset($parent_id)){
        $parent_id = null;
    }
@endphp

<option value="{{ $id }}"
        @if ($parent_id && $id == $parent_id) selected @endif
        @if ($currentId && $id == $currentId) disabled @endif>
    {{ $tab . $category->title }}
</option>

@if (isset($category->childs))
    @foreach($category->childs as $id => $child)
        @include('admin.templates.adminSelectCategory_tpl', ['category' => $child, '$currentId' => $currentId, "id" => $id, 'tab'=>$tab . '-'])
    @endforeach
@endif
