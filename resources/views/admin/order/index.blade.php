@extends('layouts.admin')
@section('title', "Список заказов")
@section('content')
    <div class="order-content">
        <section class="content-header">
            <h1>
                Список заказов
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route("admin.index")}}">
                        <div class="fa fa-shopping-cart"></div>
                        Главная</a></li>
                <li class="active">Список заказов</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Покупатель</th>
                                        <th>Статус</th>
                                        <th>Сумма</th>
                                        <th>Дата создания</th>
                                        <th>Дата изменения</th>
                                        <th>Описание</th>
                                        <th>Действие</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orders as $order)
                                    <tr class="{{$order['status']?" success":'' }}">
                                        <td>{{ $order['id']}}</td>
                                        <td>{{ $order['name']}}</td>
                                        <td>{{ $order['status'] ? "Завершён" : "Не завершён"}}</td>
                                        <td>{{ $order['sum']}}</td>
                                        <td>{{ $order['date']}}</td>
                                        <td>{{ $order['update_at']}}</td>
                                        <td>{{ $order['note']}}</td>
                                        <td><a href=""><i
                                                    class="fa fa-eye"></i></a>
                                            <a href="{{route('admin.order.delete')}}?id={{$order['id']}}"
                                               class="fa fa-trash delete"></a></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="text-center">
                                    {{$orders->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="preload"><img src="/public/images/ring.svg" alt=""></div>
    </div>
@endsection
