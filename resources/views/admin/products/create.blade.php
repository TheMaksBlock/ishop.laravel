@extends('layouts.admin')
@section('title', "Добавление товара")
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Новый товар
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
            <li><a href="{{ route('admin.products.index') }}">Список товаров</a></li>
            <li class="active">Новый товар</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data" data-toggle="validator" id="add">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование товара</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="Наименование товара" value="{{ old('title') }}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group">
                                <label for="category_id">Родительская категория</label>
                                {!! $category_menu !!}
                            </div>

                            <div class="form-group">
                                <label for="keywords">Ключевые слова</label>
                                <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Ключевые слова" value="{{ old('keywords') }}">
                            </div>

                            <div class="form-group">
                                <label for="description">Описание</label>
                                <input type="text" name="description" class="form-control" id="description" placeholder="Описание" value="{{ old('description') }}">
                            </div>

                            <div class="form-group has-feedback">
                                <label for="price">Цена</label>
                                <input type="text" name="price" class="form-control" id="price" placeholder="Цена" pattern="^[0-9.]{1,}$" value="{{ old('price') }}" required data-error="Допускаются цифры и десятичная точка">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="old_price">Старая цена</label>
                                <input type="text" name="old_price" class="form-control" id="old_price" placeholder="Старая цена" pattern="^[0-9.]{1,}$" value="{{ old('old_price') }}" data-error="Допускаются цифры и десятичная точка">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="content">Контент</label><br>
                                <textarea name="content" id="editor1" cols="80" rows="10">{{ old('content') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="status" {{ old('status') ? 'checked' : '' }}> Показывать
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="hit" {{ old('hit') ? 'checked' : '' }}> Хит
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="related">Связанные товары</label>
                                <select name="related[]" class="form-control select2" id="related" multiple></select>
                            </div>

                            {!! $filter_Menu !!}

                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="box box-danger box-solid file-upload">
                                        <div class="box-header">
                                            <h3 class="box-title">Базовое изображение</h3>
                                        </div>
                                        <div class="box-body">
                                            <div id="single" class="btn btn-success" data-url="{{route("admin.product.addImage")}}" data-name="single">Выбрать файл</div>
                                            <p><small>Рекомендуемые размеры: 125х200</small></p>
                                            <div class="single"></div>
                                        </div>
                                        <div class="overlay">
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="box box-primary box-solid file-upload">
                                        <div class="box-header">
                                            <h3 class="box-title">Картинки галереи</h3>
                                        </div>
                                        <div class="box-body">
                                            <div id="multi" class="btn btn-success" data-url="{{route("admin.product.addImage")}}" data-name="multi">Выбрать файл</div>
                                            <p><small>Рекомендуемые размеры: 700х1000</small></p>
                                            <div class="multi"></div>
                                        </div>
                                        <div class="overlay">
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
