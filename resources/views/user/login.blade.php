@php use function PHPUnit\Framework\isNull; @endphp
@extends('layouts.watches')
@section('title', "Авторизаия")
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumbs-main">
                <ol class="breadcrumb">
                    <li><a href="{{route("main.index")}}">Главная</a></li>
                    <li>Вход</li>
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
                    <div class="product-one signup">
                        <div class="register-top heading">
                            <h2>Вход</h2>
                        </div>
                        <div class="register-main">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="col-md-6 account-left">
                                <form method="post" action="{{route("login.login")}}" id="signup" role="form" data-toggle="validator">
                                    @csrf
                                    <div class="form-group has-feedback">
                                        <label for="login">Имя пользователя</label>
                                        <input type="text" name="login" class="form-control" id="login" placeholder="Login" value="" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="pasword">Пароль</label>
                                        <input type="password" name="password" class="form-control" id="pasword"
                                               placeholder="Password" data-error="Пароль должен быть не менее 6 символов"
                                               data-minlength="6" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <button type="submit" class="btn btn-default"><b>Войти</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
