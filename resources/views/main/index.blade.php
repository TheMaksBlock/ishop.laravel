@extends('layouts.watches')
@section('title', 'Главная')
@section('content')
<!--banner-starts-->
<div class="bnr" id="home">
    <div id="top" class="callbacks_container">
        <ul class="rslides" id="slider4">
            <li>
                <img src="{{ asset('images/bnr-1.jpg')}}" alt=""/>
            </li>
            <li>
                <img src="{{ asset('images/bnr-2.jpg')}}" alt=""/>
            </li>
            <li>
                <img src="{{ asset('images/bnr-3.jpg')}}" alt=""/>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
</div>
<!--banner-ends-->

<!--End-slider-script-->
<!--about-starts-->


@if ($hits)
<div class="product >
    <div class="container">
        <div class="product-top">
            <div class="product-one">
                @foreach ($hits as $hit)
                    <div class="col-md-3 product-left">
                        <div class="product-main simpleCart_shelfItem">
                            <a href="/product/{{ $hit->alias }}" class="mask">
                                <img class="img-responsive zoom-img" src="/images/{{ $hit->img }}" alt=""/>
                            </a>
                            <div class="product-bottom">
                                <h3>{{ $hit->title }}</h3>
                                <p>Explore Now</p>

                                <h4>
                                    <a data-id="{{ $hit->id }}" class="add-to-cart-link" href="/cart/add?id={{ $hit->id }}">
                                        <i></i>
                                    </a>
                                    <span class="item_price">{{$currency['symbol_left'].$hit->price *$currency['value'].$currency['symbol_right']}}</span>
                                    @if ($hit->old_price)
                                        <small><del>{{ $currency['symbol_left'].$hit->old_price*$currency['value'].$currency['symbol_right'] }}</del></small>
                                    @endif
                                </h4>
                            </div>
                            @if ($hit->old_price)
                                <div class="srch">
                                    <span>-{{ round((1 - $hit->price / $hit->old_price) * 100) }}%</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

@endif
    <!--product-end-->
@endsection('content')
