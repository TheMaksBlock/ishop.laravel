@extends('layouts.admin')
@section('title', "Список валют")
@section('content')
    <div class="order-content">
        <section class="content-header">
            <h1>
                Список Валют
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route("admin.index")}}">
                        <div class="fa fa-shopping-cart"></div>
                        Главная</a></li>
                <li class="active">Список валют</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Наименование</th>
                                        <th>Код</th>
                                        <th>Значение</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($currencies as $currency)
                                    <tr>
                                        <td>{{$currency["id"]}}</td>
                                        <td>{{$currency["title"]}}</td>
                                        <td>{{$currency["code"]}}</td>
                                        <td>{{$currency["value"]}}</td>
                                        <td>
                                            <a href="{{route("admin.currency.edit", [$currency["id"]])}}"><i class="fa fa-fw fa-pencil"></i></a>
                                            {{--<a class="delete" href="<?=ADMIN;?>/currency/delete?id=<?=$currency->id;?>"><i class="fa fa-fw fa-close text-danger"></i></a>--}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
@endsection
