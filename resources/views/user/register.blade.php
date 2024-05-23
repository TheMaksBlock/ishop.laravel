@php use function PHPUnit\Framework\isNull; @endphp
@extends('layouts.watches')
@section('title', "Регистрация")
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumbs-main">
                <ol class="breadcrumb">
                    <li><a href="{{route("main.index")}}">Главная</a></li>
                    <li>Регистрация</li>
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
                            <h2>Рагистрация</h2>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="register-main">
                            <div class="col-md-6 account-left">
                                <form method="post" action="{{ route('register.create') }}" id="signup" role="form" data-toggle="validator">
                                    @csrf
                                    <div class="form-group has-feedback">
                                        <label for="login">Имя пользователя</label>
                                        <input type="text" name="login" class="form-control" id="login" placeholder="Login" value="{{ old('login') }}" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="password">Пароь</label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" data-error="Пароль должен быть не менее 6 символов" data-minlength="6" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="name">Имя</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Имя" value="{{ old('name') }}" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="address">Адрес</label>
                                        <input type="text" name="address" class="form-control" id="address" placeholder="Address" value="{{ old('address') }}" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <button type="submit" class="btn btn-default"><b>Зарегистрировать</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
