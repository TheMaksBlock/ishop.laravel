<div class="nav-tabs-custom" id="filter">
    <ul class="nav nav-tabs">
        @foreach($groups as $group_id => $group_item)
            <li @if($loop->first) class="active" @endif>
                <a href="#tab_{{ $group_id }}" data-toggle="tab" aria-expanded="true">{{ $group_item->title }}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach($groups as $group_id => $group_item)
            @if(!empty($attrs[$group_id]))
                <div class="tab-pane @if($loop->first) active @endif" id="tab_{{ $group_id }}">
                    @foreach($attrs[$group_id] as $attr_id => $value)
                        @php
                            $checked = !empty($filter) && in_array($attr_id, $filter) ? 'checked' : '';
                        @endphp
                        <div class="form-group">
                            <label>
                                <input type="radio" name="attrs[{{ $group_id }}]" value="{{ $attr_id }}" {{ $checked }}> {{ $value }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
</div>

