@extends('layouts.admin')
@section('title', "Редактирование товара")
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Новый товар
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
            <li><a href="{{ route('admin.products.index') }}">Список товаров</a></li>
            <li class="active">Редактирование товар</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{route("admin.product.update", [$product->id])}}" method="post"
                          data-toggle="validator">
                        @csrf
                        @method('PUT')
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование товара</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       placeholder="Наименование товара" value="{{$product->title}}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group">
                                <label for="category_id">Родительская категория</label>
                                {!! $category_menu !!}
                            </div>

                            <div class="form-group">
                                <label for="keywords">Ключевые слова</label>
                                <input type="text" name="keywords" class="form-control" id="keywords"
                                       placeholder="Ключевые слова" value="{{$product->keywords}}">
                            </div>

                            <div class="form-group">
                                <label for="description">Описание</label>
                                <input type="text" name="description" class="form-control" id="description"
                                       placeholder="Описание" value="{{$product->description}}">
                            </div>

                            <div class="form-group has-feedback">
                                <label for="price">Цена</label>
                                <input type="text" name="price" class="form-control" id="description" placeholder="Цена"
                                       pattern="^[0-9.]{1,}$" value="<?=$product->price;?>" required
                                       data-error="Допускаются цифры и десятичная точка">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="old_price">Старая цена</label>
                                <input type="text" name="old_price" class="form-control" id="description"
                                       placeholder="Старая цена" pattern="^[0-9.]{1,}$"
                                       value="{{$product->old_price}}"
                                       data-error="Допускаются цифры и десятичная точка">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="content">Контент</label>
                                <textarea name="content" id="editor1" cols="80"
                                          rows="10">{{$product->content}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="status" {{$product->status ? ' checked' : null}}>
                                    Показывать
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="hit" {{$product->hit ? ' checked' : null}}> Хит
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="related">Связанные товары</label>
                                <select name="related[]" class="form-control select2" id="related" multiple>
                                    @if(!$related_products->isEmpty())
                                        @foreach($related_products as $item)
                                            <option value="{{$item->id}}" selected>{{$item->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            {!! $filter_Menu !!}
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="box box-danger box-solid file-upload">
                                        <div class="box-header">
                                            <h3 class="box-title">Базовое изображение</h3>
                                        </div>
                                        <div class="box-body">
                                            <div id="single" class="btn btn-success"
                                                 data-url="{{route("admin.product.addImage")}}"
                                                 data-name="single">Выбрать файл
                                            </div>
                                            <p><small>Рекомендуемые размеры: 125х200</small></p>
                                            <div class="single">
                                                <span class="img">
                                                    <img src="/images/{{$product->img}}" alt=""
                                                         style="max-height: 150px;">
                                                    <a class="delete close"
                                                       href="{{ route('admin.product.deleteImage', ["t"=>"single", "name" =>$product->img]) }}"><i
                                                            class="fa fa-fw fa-close text-danger"></i></a>
                                                </span>
                                            </div>
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
                                            <div id="multi" class="btn btn-success"
                                                 data-url="{{route("admin.product.addImage")}}"
                                                 data-name="multi">Выбрать файл
                                            </div>
                                            <p><small>Рекомендуемые размеры: 700х1000</small></p>
                                            <div class="multi">
                                                @if(!$gallery->isEmpty())
                                                        @foreach($gallery as $item)
                                                            <span class="img">
                                                                <img src="{{asset("images/".$item->img)}}" alt=""
                                                                     style="max-height: 150px; cursor: pointer;"
                                                                     data-id="{{$product->id}}" data-src="{{$item}};"
                                                                     class="del-item">

                                                                <a class="delete close"
                                                                   href="{{ route('admin.product.deleteImage', ["t"=>"multi", "name" =>$item->img]) }}"><i
                                                                        class="fa fa-fw fa-close text-danger"></i></a>
                                                            </span>
                                                        @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="overlay">
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
