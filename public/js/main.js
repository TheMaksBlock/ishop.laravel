/* Search */
var products = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        wildcard: '%QUERY',
        url: path + '/search/typeahead?query=%QUERY'
    }
});

products.initialize();

$("#typeahead").typeahead({
    highlight: true
},{
    name: 'products',
    display: 'title',
    limit: 9,
    source: products
});

$('#typeahead').bind('typeahead:select', function(ev, suggestion) {
    // console.log(suggestion);
    window.location = path + '/search/?s=' + encodeURIComponent(suggestion.title);
});

/*Cart*/
$('body').on('click','.add-to-cart-link', function(e) {
    e.preventDefault();
    var id = $(this).data('id'),
        qty = $('.quantity input').val() ? $('.quantity input').val():1;
    $.ajax({
        url: '/cart/add',
        data: {id: id, qty: qty},
        type: 'GET',
        success: function(res) {
           showCart(res);
        },
        error: function(){
            alert("Ошибка! Попробуйте позже")
        }
    })
});

function showCart(cart){
    if($.trim(cart) == '<h3>Корзина пуста</h3>'){
        $('#cart .modal-footer a, #cart .modal-footer .btn-danger').css('display', 'none');
    }else{
        $('#cart .modal-footer a, #cart .modal-footer .btn-danger').css('display', 'inline-block');
    }
    $('#cart .modal-body').html(cart);
    $('#cart').modal();

    if($('.cart-sum').text()){
        $('.simpleCart_total').html($('#cart .cart-sum').text());
    }else {
        $('.simpleCart_total').text("Empty Cart")
    }
}

function getCart() {
    $.ajax({
        url: '/cart/show',
        type: 'GET',
        success: function(res){
            showCart(res);
        },
        error: function(){
            alert('Ошибка! Попробуйте позже');
        }
    });
}

function clearCart()
{
    $.ajax({
        url: '/cart/clear',
        type: 'GET',
        success: function (res){
            showCart(res);
        },
        error: function (){
            alert('Ошибка! Попробуйте позже');
        }
    })

    return false;
}

$('#cart .modal-body').on('click','.del-item', function (){
    var id = $(this).data('id');
    $.ajax({
        url: '/cart/delete',
        data: {id:id},
        type: 'GET',
        success: function (res){
            showCart(res);
        },
        error: function (){
            alert('Ошибка! Попробуйте позже');
        }
    })
})
/*Cart*/


$('#currency').change(function(){
    window.location = '/currency/change/' + $(this).val();
});


/*
/!*filters*!/
$('body').on('change', '.w_sidebar input', function(){
    var checked = $('.w_sidebar input:checked'),
        data = '';

    checked.each(function () {
        data += this.value + ',';
    });

    if(data){
        $.ajax({
            url: location.href,
            data: {filter: data},
            type: 'GET',
            beforeSend: function(){
                $('.preload').fadeIn(300,function(){
                    $('.product-one').hide();
                });
            },
            success: function(res){
                $('.preload').fadeOut('slow',function(){
                    $('.product-one').html(res).fadeIn(300);
                    var url = location.search.replace(/filter(.+?)(&|$)/g, ''); //$2
                    var newURL = location.pathname + url + (location.search ? "&" : "?") + "filter=" + data;
                    newURL = newURL.replace('&&', '&');
                    newURL = newURL.replace('?&', '?');
                    newURL = newURL.slice(0, -1);
                    history.pushState({}, '', newURL);
                });
            },
            error: function(){
                alert("Error");
            }

        })
    } else{
        window.location = location.pathname;
    }
});
/!*filters*!/*/
