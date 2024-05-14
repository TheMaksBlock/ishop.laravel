@php use function PHPUnit\Framework\isEmpty;use function PHPUnit\Framework\isNull; @endphp
@extends('layouts.watches')
@section('title', $categoryTitle)
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
    <div class="prdt">
        <div class="container">
            <div class="prdt-top">

                <div class="col-md-9 prdt-left">
                    @if( !$products->isEmpty())
                        <div class="product-one">
                            @foreach ($products as $product)
                                <div class="col-md-4 product-left p-left">
                                    <div class="product-main simpleCart_shelfItem">
                                        <a href="/product/{{ $product->alias }}" class="mask">
                                            <img class="img-responsive zoom-img" src="/images/{{ $product->img }}"
                                                 alt=""/>
                                        </a>
                                        <div class="product-bottom">
                                            <h3>{{ $product->title }}</h3>
                                            <p>Explore Now</p>

                                            <h4>
                                                <a data-id="{{ $product->id }}" class="add-to-cart-link"
                                                   href="/cart/add?id={{ $product->id }}">
                                                    <i></i>
                                                </a>
                                                <span
                                                    class="item_price">{{ $currency['symbol_left'].$product->price *$currency['value'].$currency['symbol_right'] }}</span>
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

                            <div class="text-center">
                                {{$products->links()}}
                            </div>
                        </div>
                    @else
                        <h3>Товаров не найдено</h3>
                    @endif
                </div>
                <div class="col-md-3 prdt-right">
                    <div class="w_sidebar">
                        <?php /*new \app\widgets\filter\Filter() */ ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection
