@php use function PHPUnit\Framework\isEmpty; @endphp
@extends('layouts.admin')
@section('title', "Инофрмация о пользователе")
@section('content')
<section class="content-header">
    <h1>
        Редактирование пользователя
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.user.index') }}">Список пользователей</a></li>
        <li class="active">Редактирование пользователя</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <form action="{{ route('admin.user.update', $user->id) }}" method="post" data-toggle="validator">
                    @csrf
                    @method('PUT')
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="login">Логин</label>
                            <input type="text" class="form-control" name="login" id="login" value="{{ $user->login }}" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль, если хотите его изменить">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="address">Адрес</label>
                            <input type="text" class="form-control" name="address" id="address" value="{{ $user->address }}" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group">
                            <label>Роль</label>
                            <select name="role" id="role" class="form-control">
                                <option value="user" @if($user->role == 'user') selected @endif>Пользователь</option>
                                <option value="admin" @if($user->role == 'admin') selected @endif>Администратор</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>

            <h3>Заказы пользователя</h3>
            <div class="box">
                <div class="box-body">
                    @if(!empty($orders))
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Статус</th>
                                <th>Сумма</th>
                                <th>Дата создания</th>
                                <th>Дата изменения</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                            <tr class="{{ $order->status ? 'success' : '' }}">
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->status ? 'Завершен' : 'Новый' }}</td>
                                <td>{{ $order->sum }} {{ $order->currency }}</td>
                                <td>{{ $order->date }}</td>
                                <td>{{ $order->update_at }}</td>
                                <td><a href="{{ route('admin.order.show', $order->id) }}"><i class="fa fa-fw fa-eye"></i></a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-danger">Пользователь пока ничего не заказывал...</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

@endsection
