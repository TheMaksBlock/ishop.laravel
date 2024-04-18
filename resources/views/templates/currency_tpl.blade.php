<?php xdebug_break(); ?>
<option value="" class="label">{{ $currency['code'] }} :</option>
@foreach ($currencies as $k => $v)
    @if ($k != $currency['code'])
        <option value="{{ $k }}">{{ $k}}</option>
    @endif
@endforeach
