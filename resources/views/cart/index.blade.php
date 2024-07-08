@extends('layouts.watches')
@section('title', "Корзина")
@section('content')
<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="{{route('main.index')}}">Главная</a></li>
                <li>Корзина</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->
<!--prdt-starts-->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-12">
                <div class="product-one cart">
                    <div class="register-top heading">
                        <h2>Оформление заказа</h2>
                    </div>
                    <br><br>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
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
                                        <td>{{ $item->price }}</td>

                                        <td><span data-id="{{$item->id}}" class="glyphicon glyphicon-remove text-danger del-item"></span> </td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td>Итого:</td>
                                <td colspan="4" class="text-right cart-qty">{{$cart['qty']}}</td>
                            </tr>
                            {{--<tr>
                                <td>На сумму:</td>
                                <td colspan="4" class="text-right cart-sum">{{$cart['currency']['symbol_left'].$cart['sum'].$cart['currency']['symbol_right'] }}</td>
                            </tr>
                            </tbody>--}}
                        </table>
                    </div>
                   <div class="col-md-6 account-left">
                        <form method="post" action="{{route("cart.checkout")}}" role="form" data-toggle="validator">
                            <div class="form-group">
                                @csrf
                                <label for="address">Note</label>
                                <textarea name="note" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-default">Оформить</button>
                        </form>
                    </div>
                    @else
                    <h3>Корзина пуста</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
