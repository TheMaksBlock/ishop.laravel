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
                                <div class="star-on">
                                    <ul class="star-footer">
                                        <li><a href="/#"><i> </i></a></li>
                                        <li><a href="/#"><i> </i></a></li>
                                        <li><a href="/#"><i> </i></a></li>
                                        <li><a href="/#"><i> </i></a></li>
                                        <li><a href="/#"><i> </i></a></li>
                                    </ul>
                                    <div class="review">
                                        <a href="/#"> 1 customer review </a>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <h5 class="item_price" id="base-price"
                                    data-base="{{$product->old_price * $currency['value']}}">

                                    @if ($product->old_price)
                                        <small>
                                            <del>{{$currency['symbol_left'].$product->old_price * $currency['value'].$currency['symbol_right']}}</del>
                                        </small>
                                    @endif
                                    {{$currency['symbol_left'].$product->price * $currency['value'].$currency['symbol_right']}}
                                </h5>
                                <p>{{$product->Content}} </p>
                                {{--@if($mods)
                                <div class="available">
                                    <ul>
                                        <li>Color
                                            <select>
                                                <option>Выбрать цвет</option>
                                                    <?php
                                                foreach ($mods as $mod): ?>
                                                <option data-title="<?= $mod->title ?>"
                                                        data-price="<?= $mod->price * $currency['value'] ?>"
                                                        value="<?= $mod->id ?>"><?= $mod->title ?></option>
                                                <?php
                                                endforeach; ?>
                                            </select></li>
                                        <div class="clearfix"></div>
                                    </ul>
                                </div>
                                @endif--}}
                                <ul class="tag-men">
                                    <li><span>Category</span>
                                        <span>:<a href="{{ route('category.show', ['category' => $product->alias]) }}">
                                            {{$product->title}}</a></span>
                                    </li>
                                </ul>

                                <div class="quantity">
                                    <input type="number" size="4" value="1" name="quantity" min="1" step="1"
                                           class="input-lg">
                                </div>
                                <a id="productAdd" data-id="<?= $product->id ?>" href="/cart/add?id=<?= $product->id ?>"
                                   class="add-cart item_add add-to-cart-link">ADD TO CART</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="tabs">
                        <ul class="menu_drop">
                            <li class="item1"><a href="/#"><img src="/images/arrow.png" alt="">Description</a>
                                <ul>
                                    <li class="subitem1"><a href="/#">Lorem ipsum dolor sit amet, consectetuer
                                            adipiscing
                                            elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna
                                            aliquam
                                            erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation
                                            ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</a>
                                    </li>
                                    <li class="subitem2"><a href="/#"> Duis autem vel eum iriure dolor in hendrerit in
                                            vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla
                                            facilisis at vero eros et accumsan et iusto odio dignissim qui blandit
                                            praesent
                                            luptatum zzril delenit augue duis dolore</a></li>
                                    <li class="subitem3"><a href="/#">Mirum est notare quam littera gothica, quam nunc
                                            putamus parum claram, anteposuerit litterarum formas humanitatis per seacula
                                            quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur
                                            parum
                                            clari, fiant sollemnes </a></li>
                                </ul>
                            </li>
                            <li class="item2"><a href="/#"><img src="/images/arrow.png" alt="">Additional
                                    information</a>
                                <ul>
                                    <li class="subitem2"><a href="/#"> Duis autem vel eum iriure dolor in hendrerit in
                                            vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla
                                            facilisis at vero eros et accumsan et iusto odio dignissim qui blandit
                                            praesent
                                            luptatum zzril delenit augue duis dolore</a></li>
                                    <li class="subitem3"><a href="/#">Mirum est notare quam littera gothica, quam nunc
                                            putamus parum claram, anteposuerit litterarum formas humanitatis per seacula
                                            quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur
                                            parum
                                            clari, fiant sollemnes </a></li>
                                </ul>
                            </li>
                            <li class="item3"><a href="/#"><img src="/images/arrow.png" alt="">Reviews (10)</a>
                                <ul>
                                    <li class="subitem1"><a href="/#">Lorem ipsum dolor sit amet, consectetuer
                                            adipiscing
                                            elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna
                                            aliquam
                                            erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation
                                            ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</a>
                                    </li>
                                    <li class="subitem2"><a href="/#"> Duis autem vel eum iriure dolor in hendrerit in
                                            vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla
                                            facilisis at vero eros et accumsan et iusto odio dignissim qui blandit
                                            praesent
                                            luptatum zzril delenit augue duis dolore</a></li>
                                    <li class="subitem3"><a href="/#">Mirum est notare quam littera gothica, quam nunc
                                            putamus parum claram, anteposuerit litterarum formas humanitatis per seacula
                                            quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur
                                            parum
                                            clari, fiant sollemnes </a></li>
                                </ul>
                            </li>
                            <li class="item4"><a href="/#"><img src="/images/arrow.png" alt="">Helpful Links</a>
                                <ul>
                                    <li class="subitem2"><a href="/#"> Duis autem vel eum iriure dolor in hendrerit in
                                            vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla
                                            facilisis at vero eros et accumsan et iusto odio dignissim qui blandit
                                            praesent
                                            luptatum zzril delenit augue duis dolore</a></li>
                                    <li class="subitem3"><a href="/#">Mirum est notare quam littera gothica, quam nunc
                                            putamus parum claram, anteposuerit litterarum formas humanitatis per seacula
                                            quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur
                                            parum
                                            clari, fiant sollemnes </a></li>
                                </ul>
                            </li>
                            <li class="item5"><a href="/#"><img src="/images/arrow.png" alt="">Make A Gift</a>
                                <ul>
                                    <li class="subitem1"><a href="/#">Lorem ipsum dolor sit amet, consectetuer
                                            adipiscing
                                            elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna
                                            aliquam
                                            erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation
                                            ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</a>
                                    </li>
                                    <li class="subitem2"><a href="/#"> Duis autem vel eum iriure dolor in hendrerit in
                                            vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla
                                            facilisis at vero eros et accumsan et iusto odio dignissim qui blandit
                                            praesent
                                            luptatum zzril delenit augue duis dolore</a></li>
                                    <li class="subitem3"><a href="/#">Mirum est notare quam littera gothica, quam nunc
                                            putamus parum claram, anteposuerit litterarum formas humanitatis per seacula
                                            quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur
                                            parum
                                            clari, fiant sollemnes </a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="latestproducts">
                        @if ($related)
                            <div class="product-one">
                                <h3> С этим товаром также покупают:</h3>
                                @foreach ($related as $rel)
                                    <div class="col-md-3 product-left">
                                        <div class="product-main simpleCart_shelfItem">
                                            <a href="/product/{{ $rel->alias }}" class="mask">
                                                <img class="img-responsive zoom-img" src="/images/{{ $rel->img }}"
                                                     alt=""/>
                                            </a>
                                            <div class="product-bottom">
                                                <h3>{{ $rel->title }}</h3>
                                                <p>Explore Now</p>

                                                <h4>
                                                    <a data-id="{{ $rel->id }}" class="add-to-cart-link"
                                                       href="/cart/add?id={{ $rel->id }}">
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
