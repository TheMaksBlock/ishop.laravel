$('.delete').click(function(){
    var res = confirm('Подтвердите действие');
    if(!res) {
        return false;
    }
});

$('body').on('change', '.get-confirmed-orders input', function(){

    var checked = $('.get-confirmed-orders input:checked');

    $.ajax({
        url: location.href,
        data: {confirmed_orders: checked.length>0},
        type: 'POST',
        beforeSend: function(){
            $('.preload').fadeIn(300,function(){
                $('.order-content').hide();
            });
        },
        success: function(res){
            $('.order-content').html(res).show();
        },
        error: function(){
            alert("Error");
        }

    })
    $('.preload').fadeOut(300);
});



$('.sidebar-menu a').each(function(){
    var loc = window.location.protocol + '//' + window.location.host+window.location.pathname;
    console.log(loc);
    var link = this.href;

    if(link==location){
        $(this).parent().addClass('active');
        $(this).closest('.treeview').addClass('active');
    }
});