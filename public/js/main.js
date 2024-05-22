/* Search */
var currentFilter = getParameterByName('filter');

var products = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        wildcard: '%QUERY',
        url: path + 'catalog/typeahead?query=%QUERY' + (currentFilter ? '&filter=' + currentFilter : '')
    }
});

products.initialize();

$("#typeahead").typeahead({
    highlight: true
}, {
    name: 'products',
    display: 'title',
    limit: 9,
    source: products
});

$('#typeahead').bind('typeahead:select', function(ev, suggestion) {
    let currentUrl = location.href.split('?')[0];
    if (currentUrl.includes('catalog')) {
        console.log(1);
        window.location = currentUrl+'?s=' + encodeURIComponent(suggestion.title)+ (currentFilter ? '&filter=' + currentFilter : '');
    } else {
        console.log(2);
        window.location = path +'catalog?s='+encodeURIComponent(suggestion.title)+ (currentFilter ? '&filter=' + currentFilter : '');
    }

});

function getParameterByName(name) {
    var url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

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



$('body').on('change', '.w_sidebar input', function() {
    var checked = $('.w_sidebar input:checked');
    var data = '';

    checked.each(function() {
        data += this.value + ',';
    });

    data = data.slice(0, -1); // Удаляем последнюю запятую

    // Определяем URL для AJAX запроса
    var url = location.href.split('?')[0];

    $.ajax({
        url: location.href,
        data: data ? { filter: data } : {}, // Если data не пустая, добавляем параметр filter
        type: 'GET',
        beforeSend: function() {
            $('.preload').fadeIn(300, function() {
                $('.product-one').hide();
            });
        },
        success: function(res) {
            $('.preload').fadeOut('slow', function() {
                $('.product-one').html(res).fadeIn(300);

                var newURL = location.pathname;
                var searchParams = new URLSearchParams(location.search);

                if (!data) {
                    searchParams.delete('filter');
                } else {
                    searchParams.set('filter', data);
                }

                searchParams.delete('page'); // Удаляем параметр страницы при изменении фильтра

                newURL += '?' + searchParams.toString();

                history.pushState({}, '', newURL);

                currentFilter = getParameterByName('filter');
            });
        },
        error: function() {
            alert("Error");
            $('.preload').fadeOut('slow');
        }
    });
});
