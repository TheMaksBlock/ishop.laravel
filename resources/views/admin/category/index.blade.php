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
                <li class="active">Список категорий</li>
            </ol>
        </section>

        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                            {!! $category_menu !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
