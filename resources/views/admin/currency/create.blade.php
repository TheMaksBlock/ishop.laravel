@extends('layouts.admin')
@section('title', "Список валют")
@section('content')
    <div class="order-content">
        <section class="content-header">
            <h1>
                Создание валюты
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route("admin.index")}}">
                        <div class="fa fa-shopping-cart"></div>
                        Главная</a></li>
                <li><a href="{{route("admin.currency.index")}}">Список валют</a></li>
                <li class="active">Создание валюты</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <form method="post" action="{{route("admin.currency.store")}}" role="form" data-toggle="validator">
                            @csrf
                            <div class="box-body">
                                <div class="form-group has-feedback">
                                    <label for="title">Наименование валюты</label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Наименование валюты" required value="{{old("title")}}">
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="code">Код валюты</label>
                                    <input type="text" name="code" class="form-control" id="code" placeholder="Код валюты" required value="{{old("code")}}">
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="form-group">
                                    <label for="symbol_left">Символ слева</label>
                                    <input type="text" name="symbol_left" class="form-control" id="symbol_left" placeholder="Символ слева" value="{{old("symbol_left")}}">
                                </div>
                                <div class="form-group">
                                    <label for="symbol_right">Символ справа</label>
                                    <input type="text" name="symbol_right" class="form-control" id="symbol_right" placeholder="Символ справа" value="{{old("symbol_left")}}">
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="value">Значение</label>
                                    <input type="text" name="value" class="form-control" id="value" placeholder="Значение" pattern="^[0-9.]{1,}$" required data-error="Допускаются цифры и десятичная точка" value="{{old("symbol_left") }}">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input name="base" type="checkbox" @if(old('base')) checked @endif> Базовая влюта
                                    </label>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-success">Сохранить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
@endsection
