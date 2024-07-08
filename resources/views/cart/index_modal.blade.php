@if(!$cart["items"]->isEmpty())
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Фото</th>
            <th>Наименование</th>
            <th>Кол-во</th>
            <th>Цена</th>
            <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($cart["items"] as $item)
            @if(isset($item->alias))
            <tr>
                <td><a href="{{ route('product.show', [$item->alias]) }}"><img src="{{ asset('images/' . $item->img) }}" alt=""></a></td>
                <td><a href="{{ route('product.show', [$item->alias]) }}">{{ $item->title }}</a></td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $currency['symbol_left'].$item->price.$currency['symbol_right'] }}</td>

                <td><span data-id="{{$item->id}}" class="glyphicon glyphicon-remove text-danger del-item"></span> </td>
            </tr>
            @endif
        @endforeach
        <tr>
            <td>Итого:</td>
            <td colspan="4" class="text-right cart-qty">{{$cart['qty']}}</td>
        </tr>
        <tr>
            <td>На сумму:</td>
            <td colspan="4" class="text-right cart-sum">{{$currency['symbol_left'].$cart['sum'].$currency['symbol_right'] }}</td>
        </tr>
        </tbody>
    </table>
</div>
@else
<h3>Корзина пуста</h3>
@endif
