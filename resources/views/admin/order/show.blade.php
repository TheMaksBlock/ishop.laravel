@extends('layouts.admin')
@section('title', "Заказ № $order->id")
@section('content')
    <section class="content-header">
        <h1>
            Заказ №{{ $order->id }}<br>
            <a href="{{ route('admin.order.change-status', ["id" => $order->id, "status" => !$order->status]) }}"
               class="btn btn-success btn-xs">{{ $order->status ? 'Доработать' : 'Завершить' }}</a>
            <a href="{{ route('admin.order.delete', ["id" => $order->id])}}" class="btn btn-danger btn-xs delete">Удалить</a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><div class="fa fa-shopping-cart"></div> Главная</a></li>
            <li><a href="{{ route('admin.order.index') }}">Список заказов</a></li>
            <li class="active">Заказ №{{ $order->id }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                <tr>
                                    <td>Номер заказа</td>
                                    <td>{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <td>Имя заказчика</td>
                                    <td>{{ $order->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Дата заказа</td>
                                    <td>{{ $order->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>Дата изменения</td>
                                    <td>{{ $order->updated_at }}</td>
                                </tr>
                                <tr>
                                    <td>Количество позиций в заказе</td>
                                    <td>{{ $products->count()}}</td>
                                </tr>
                                <tr>
                                    <td>Сумма заказа</td>
                                    <td>{{ $order->sum }} {{ $order->currency }}</td>
                                </tr>
                                <tr>
                                    <td>Статус</td>
                                    <td>{{ $order->status ? "Завершён" : "Не завершён" }}</td>
                                </tr>
                                <tr>
                                    <td>Комментарий</td>
                                    <td>{{ $order->note }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название товара</th>
                                    <th>Количество</th>
                                    <th>Сумма</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->qty }}</td>
                                        <td>{{ $product->price }} {{ $order->currency}}</td>
                                    </tr>
                                @endforeach
                                <tr class="active">
                                    <td colspan="2">Итого</td>
                                    <td><b>{{ $order->orderProducts->sum('qty')}}</b></td>
                                    <td><b>{{ $order->sum }} {{ $order->currency }}</b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
