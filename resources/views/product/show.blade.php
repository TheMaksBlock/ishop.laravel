@php use function PHPUnit\Framework\isNull; @endphp
@extends('layouts.watches')
@section('title', $product->title)
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumbs-main">
                <ol class="breadcrumb">
                    {!! $breadCrumbs !!}
                </ol>
            </div>
        </div>
    </div>
    <!--end-breadcrumbs-->
    <!--start-single-->
    <div class="single contact">
        <div class="container">
            <div class="single-main">
                <div class="col-md-9 single-main-left">
                    <div class="sngl-top">
                        @if (!$gallery->isEmpty())
                            <div class="col-md-5 single-top-left">
                                <div class="flexslider">
                                    <ul class="slides">
                                        @foreach ($gallery as $item)
                                            <li data-thumb="/images/{{$item->img}}">
                                                <div class="thumb-image"><img src="{{ asset('images/'.$item->img)}}"
                                                                              data-imagezoom="true"
                                                                              class="img-responsive"
                                                                              alt=""/></div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="col-md-3 single-top-left">
                                <img src="{{ asset('images/'.$product->img)}}" alt="">
                            </div>
                        @endif


                        <div class="col-md-7 single-top-right">
                            <div class="single-para simpleCart_shelfItem">
                                <h2>{{$product->title}}</h2>

                                <h5 class="item_price" id="base-price"
                                    data-base="{{$product->old_price * $currency['value']}}">

                                    @if ($product->old_price)
                                        <small>
                                            <del>{{$currency['symbol_left'].$product->old_price * $currency['value'].$currency['symbol_right']}}</del>
                                        </small>
                                    @endif
                                    {{$currency['symbol_left'].$product->price * $currency['value'].$currency['symbol_right']}}
                                </h5>
                                <br><br><br>
                                <div class="quantity">
                                    <input type="number" size="4" value="1" name="quantity" min="1" step="1"
                                           class="input-lg">
                                </div>
                                <br>
                                <a id="productAdd" data-id="{{$product->id}}" href="{{route("cart.add",["id" =>$product->id])}}"
                                   class="add-cart item_add add-to-cart-link">Добавить в корзину</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="tabs">
                        <h3><b>Описание</b></h3>
                        {!! $product->content !!}
                    </div>
                    <div class="latestproducts">
                        @if (!$related->isEmpty())
                            <div class="product-one">
                                <h3> С этим товаром также покупают:</h3>
                                @foreach ($related as $rel)
                                    <div class="col-md-3 product-left">
                                        <div class="product-main simpleCart_shelfItem">
                                            <a href="{{ route("product.show",[$rel->alias])}}" class="mask">
                                                <img class="img-responsive zoom-img" src="/images/{{ $rel->img }}"
                                                     alt=""/>
                                            </a>
                                            <div class="product-bottom">
                                                <h3>{{ $rel->title }}</h3>

                                                <h4>
                                                    <a data-id="{{ $rel->id }}" class="add-to-cart-link"
                                                       href="{{route("cart.add",["id" =>$rel->id ])}}">
                                                        <i></i>
                                                    </a>
                                                    <span class="item_price">{{ $currency['symbol_left'].$rel->price*$currency['value'].$currency['symbol_right'] }}</span>
                                                    @if ($rel->old_price)
                                                        <small>
                                                            <del>{{ $currency['symbol_left'].$rel->old_price*$currency['value'].$currency['symbol_right'] }}</del>
                                                        </small>
                                                    @endif
                                                </h4>
                                            </div>
                                            @if ($rel->old_price)
                                                <div class="srch">
                                                    <span>-{{ round((1 - $rel->price / $rel->old_price) * 100) }}%</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                <div class="clearfix"></div>
                            </div>
                        @endif
                    </div>
                    <div class="resentlyProducts">
                        @if ($recentlyViewed)
                            <h3> Ранее просмотренные товары:</h3>
                            <div class="product-one">
                                @foreach ($recentlyViewed as $product)
                                    <div class="col-md-3 product-left">
                                        <div class="product-main simpleCart_shelfItem">
                                            <a href="{{ route("product.show",[$product->alias]) }}" class="mask">
                                                <img class="img-responsive zoom-img" src="/images/{{ $product->img }}"
                                                     alt=""/>
                                            </a>
                                            <div class="product-bottom">
                                                <h3>{{ $product->title }}</h3>

                                                <h4>
                                                    <a data-id="{{ $product->id }}" class="add-to-cart-link"
                                                       href="{{route("cart.add",["id" =>$product->id])}}">
                                                        <i></i>
                                                    </a>
                                                    <span class="item_price">{{$currency['symbol_left'].$product->price *$currency['value'].$currency['symbol_right'] }}</span>
                                                    @if ($product->old_price)
                                                        <small>
                                                            <del>{{ $currency['symbol_left'].$product->old_price *$currency['value'].$currency['symbol_right'] }}</del>
                                                        </small>
                                                    @endif
                                                </h4>
                                            </div>
                                            @if ($product->old_price)
                                                <div class="srch">
                                                    <span>-{{ round((1 - $product->price / $product->old_price) * 100) }}%</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                <div class="clearfix"></div>
                            </div>

                        @endif
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection
