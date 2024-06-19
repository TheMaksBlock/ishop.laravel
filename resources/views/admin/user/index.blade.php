@extends('layouts.admin')
@section('title', "Список пользователей")
@section('content')
    <section class="content-header">
        <h1>
            Список пользователей
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
            <li class="active">Список пользователей</li>
        </ol>
    </section>

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
                                    <th>Логин</th>
                                    <th>Email</th>
                                    <th>Имя</th>
                                    <th>Роль</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->login }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td><a href="{{ route('admin.user.edit', ["user" =>$user->id]) }}"><i
                                                    class="fa fa-fw fa-eye"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">
                                {{$users->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
