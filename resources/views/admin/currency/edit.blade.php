@extends('layouts.admin')
@section('title', "Список валют")
@section('content')
    <div class="order-content">
        <section class="content-header">
            <h1>
                Редактироание валюты
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route("admin.index")}}">
                        <div class="fa fa-shopping-cart"></div>
                        Главная</a></li>
                <li><a href="{{route("admin.currency.index")}}">Список валют</a></li>
                <li class="active">Редактирование валюты</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <form method="post" action="{{route("admin.currency.update", [$currency->id])}}" role="form" data-toggle="validator">
                            @csrf
                            @method("PUT")
                            <div class="box-body">
                                <div class="form-group has-feedback">
                                    <label for="title">Наименование валюты</label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Наименование валюты" required value="{{old("title", $currency->title)}}">
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="code">Код валюты</label>
                                    <input type="text" name="code" class="form-control" id="code" placeholder="Код валюты" required value="{{old("code", $currency->code)}}">
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="form-group">
                                    <label for="symbol_left">Символ слева</label>
                                    <input type="text" name="symbol_left" class="form-control" id="symbol_left" placeholder="Символ слева" value="{{old("symbol_left", $currency->symbol_left)}}">
                                </div>
                                <div class="form-group">
                                    <label for="symbol_right">Символ справа</label>
                                    <input type="text" name="symbol_right" class="form-control" id="symbol_right" placeholder="Символ справа" value="{{old("symbol_left", $currency->symbol_right)}}">
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="value">Значение</label>
                                    <input type="text" name="value" class="form-control" id="value" placeholder="Значение" pattern="^[0-9.]{1,}$" required data-error="Допускаются цифры и десятичная точка" value="{{old("symbol_left", $currency->value) }}">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input name="base" type="checkbox" @if($currency->base) checked @endif> Базовая валюта
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
