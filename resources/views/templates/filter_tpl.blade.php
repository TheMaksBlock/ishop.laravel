<div class="w_sidebar">
    @foreach ($groups as $id => $item)
        <section class="sky-form">
            <h4>{{ $item->title }}</h4>
            <div class="row1 scroll-pane">
                <div class="col col-4">
                    @foreach ($attrs[$id] as $k => $v)
                        <label class="checkbox">
                            <input type="checkbox" name="checkbox" value="{{ $k }}"
                                {{ !empty($filter) && in_array($k, $filter) ? 'checked' : '' }}>
                            <i></i>{{ $v }}
                        </label>
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach
</div>
