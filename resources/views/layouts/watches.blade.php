@php use App\Services\CurrencyService; @endphp
    <!DOCTYPE html>
<html lang="ru">
<head>
    <base href="/">
    <link rel="shortcut icon" href="{{ asset('images/star.png')}}" type="image/png">
    <title>@yield('title')</title>
    <link href="{{ asset('css/bootstrap.css')}}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('megamenu/css/ionicons.min.css" rel="stylesheet')}}" type="text/css" media="all"/>
    <link href="{{ asset('megamenu/css/style.css')}}" rel="stylesheet" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ asset('css/flexslider.css')}}" type="text/css" media="screen"/>
    <!--theme-style-->
    <link href="{{ asset('css/style.css')}}" rel="stylesheet" type="text/css" media="all"/>
    <!--//theme-style-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<!--top-header-->
<div class="top-header">
    <div class="container">
        <div class="top-header-main">
            <div class="col-md-6 top-header-left">
                <div class="drop">
                    <div class="box">
                        <select id="currency" tabindex="4" class="dropdown drop">
                            {!! $currencyWidget !!}
                        </select>
                    </div>
                    <div class="btn-group">
                        <a class="dropdown-toggle" data-toggle="dropdown">Аккаунт <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @auth
                                <li><a href="#">Добро пожаловать, {{ auth()->user()->login}}</a></li>
                                <li><a href="{{route("login.logout")}}">Выход</a></li>
                            @endauth
                            @guest
                                <li><a href="{{route("login.index")}}">Вход</a></li>
                                <li><a href="{{route("register.index")}}">Регистрация</a></li>
                            @endguest
                        </ul>
                    </div>


                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-6 top-header-left">
                <div class="cart box_1">
                    <a href="{{rout('cart.index')}}" onclick="getCart(); return false">
                        <div class="total">
                            <img src="{{ asset('images/cart-1.png')}}" alt="">
                            @if($cartSum)
                                <span
                                    class="simpleCart_total ">{{$currency['symbol_left'].$cartSum .$currency['symbol_right']}}</span>
                            @else
                                <span class="simpleCart_total ">Empty Cart</span>
                            @endif
                        </div>
                    </a>

                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--top-header-->
<!--start-logo-->
<div class="logo">
    <a href="{{ route('main.index') }}"><h1>Luxury Watches</h1></a>
</div>
<!--start-logo-->
<!--bottom-header-->
<div class="header-bottom">
    <div class="container">
        <div class="header">
            <div class="col-md-9 header-left">
                <div class="menu-container">
                    <div class="menu">
                        {!! $menu !!}
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-3 header-right">
                <div class="search-bar">
                    <div class="input-group">
                        <input type="text" class="form-control typeahead" id="typeahead" name="s" value="">
                        <span class="input-group-btn">
                            <button id="searchButton" class="btn btn-default" type="button">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--bottom-header-->

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{--<?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                        <?php echo $_SESSION['error'];unset($_SESSION['error'])?>
                </div>
                <?php endif;?>
                <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                        <?php echo $_SESSION['success'];unset($_SESSION['success'])?>
                </div>
                <?php endif;?>--}}
            </div>
        </div>
    </div>
    @yield('content')
</div>

<!--information-starts-->
<div class="information">
    <div class="container">
        <div class="infor-top">
            <div class="col-md-3 infor-left">
                <h3>Follow Us</h3>
                <ul>
                    <li><a href="/#"><span class="fb"></span><h6>Facebook</h6></a></li>
                    <li><a href="/#"><span class="twit"></span><h6>Twitter</h6></a></li>
                    <li><a href="/#"><span class="google"></span><h6>Google+</h6></a></li>
                </ul>
            </div>
            <div class="col-md-3 infor-left">
                <h3>Information</h3>
                <ul>
                    <li><a href="/#"><p>Specials</p></a></li>
                    <li><a href="/#"><p>New Products</p></a></li>
                    <li><a href="/#"><p>Our Stores</p></a></li>
                    <li><a href="/contact.html"><p>Contact Us</p></a></li>
                    <li><a href="/#"><p>Top Sellers</p></a></li>
                </ul>
            </div>
            <div class="col-md-3 infor-left">
                <h3>My Account</h3>
                <ul>
                    <li><a href="/account.html"><p>My Account</p></a></li>
                    <li><a href="/#"><p>My Credit slips</p></a></li>
                    <li><a href="/#"><p>My Merchandise returns</p></a></li>
                    <li><a href="/#"><p>My Personal info</p></a></li>
                    <li><a href="/#"><p>My Addresses</p></a></li>
                </ul>
            </div>
            <div class="col-md-3 infor-left">
                <h3>Store Information</h3>
                <h4>The company name,
                    <span>Lorem ipsum dolor,</span>
                    Glasglow Dr 40 Fe 72.</h4>
                <h5>+955 123 4567</h5>
                <p><a href="/mailto:example@email.com">contact@example.com</a></p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--information-end-->
<!--footer-starts-->
<div class="footer">
    <div class="container">
        <div class="footer-top">
            <div class="col-md-6 footer-left">
                <form>
                    <input type="text" value="Enter Your Email" onfocus="this.value = '';"
                           onblur="if (this.value == '') {this.value = 'Enter Your Email';}">
                    <input type="submit" value="Subscribe">
                </form>
            </div>
            <div class="col-md-6 footer-right">
                <p>© 2015 Luxury Watches. All Rights Reserved | Design by <a href="/http://w3layouts.com/"
                                                                             target="_blank">W3layouts</a></p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Корзина</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Продолжить покупки</button>
                <a href="{{route('cart.index')}}" type="button" class="btn btn-primary">Оформить заказ</a>
                <button type="button" class="btn btn-danger" onclick="clearCart()">Очистить корзину</button>
            </div>
        </div>
    </div>
</div>

<div class="preload"><img src="{{ asset('images/ring.svg')}}" alt=""></div>
<!--footer-end-->
<script>
    var path = '{{ asset('/') }}';
</script>

<script src="{{ asset('js/jquery-1.11.0.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/typeahead.bundle.js')}}"></script>
<script src="{{ asset('js/bootstrap.js')}}"></script>
<script src="{{ asset('js/validator.js')}}"></script>

<!--dropdown-->
<script src="{{ asset('js/jquery.easydropdown.js')}}"></script>
<!--Slider-Starts-Here-->
<script src="{{ asset('js/responsiveslides.min.js')}}"></script>
<script defer src="{{ asset('js/jquery.flexslider.js')}}"></script>
<script src="{{ asset('megamenu/js/megamenu.js')}}"></script>
<script src="{{ asset('js/imagezoom.js')}}"></script>
<script src="{{ asset('js/main.js')}}"></script>
<script>
    // Can also be used with $(document).ready()
    $(window).load(function () {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails"
        });
    });
</script>
<script>
    // You can also use "$(window).load(function() {"
    $(function () {
        // Slideshow 4
        $("#slider4").responsiveSlides({
            auto: true,
            pager: true,
            nav: true,
            speed: 500,
            namespace: "callbacks",
            before: function () {
                $('.events').append("<li>before event fired.</li>");
            },
            after: function () {
                $('.events').append("<li>after event fired.</li>");
            }
        });

    });
</script>

<script type="text/javascript">
    $(function () {

        var menu_ul = $('.menu_drop > li > ul'),
            menu_a = $('.menu_drop > li > a');

        menu_ul.hide();

        menu_a.click(function (e) {
            e.preventDefault();
            if (!$(this).hasClass('active')) {
                menu_a.removeClass('active');
                menu_ul.filter(':visible').slideUp('normal');
                $(this).addClass('active').next().stop(true, true).slideDown('normal');
            } else {
                $(this).removeClass('active');
                $(this).next().stop(true, true).slideUp('normal');
            }
        });

    });
</script>


</body>
</html>
