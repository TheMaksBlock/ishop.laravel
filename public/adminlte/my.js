$('#editor1').ckeditor();

$(document).on('click', '.delete', function(event) {
    const res = confirm('Подтвердите действие');
    if (!res) {
        return false;
    }
});

$('.sidebar-menu a').each(function () {
    const link = this.href;

    console.log("link: " + link + "  " + "loc: " + location + "      " + (link == location));

    if (link == location) {
        $(this).parent().addClass('active');
        $(this).closest('.treeview').addClass('active');
    }
});


if ($('div').is('#single')) {
    let buttonSingle = $("#single"),
        buttonMulti = $("#multi"),
        file;

    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    if (buttonSingle) {
        console.log(csrfToken)
        new AjaxUpload(buttonSingle, {
            action: buttonSingle.data('url'),
            data: {
                name: buttonSingle.data('name'),
                _token: csrfToken
            },
            name: buttonSingle.data('name'),
            onSubmit: function (file, ext) {
                buttonSingle.closest('.file-upload').find('.overlay').css({'display': 'block'});

            },
            onComplete: function (file, response) {
                setTimeout(function () {
                    buttonSingle.closest('.file-upload').find('.overlay').css({'display': 'none'});
                    response = JSON.parse(response.replace(/<.*?>/ig, ""));
                    if (response.error) {
                        alert(response.error);
                        return;
                    }
                    $('.' + buttonSingle.data('name')).html('<span class="img"><img src="/images/' + response.file +
                        '" style="max-height: 150px;">' +
                        '<a class="delete close" href="/admin/product/deleteImage?t=single&name='+ response.file+'"><i class="fa fa-fw fa-close text-danger"></i></a></span>');
                }, 1000);
            },
            onError: function () {
                setTimeout(function () {
                    buttonSingle.closest('.file-upload').find('.overlay').css({'display': 'none'});
                    alert("Ошибка при загрузке файла");
                }, 1000);
            }
        });
    }

    if (buttonMulti) {
        new AjaxUpload(buttonMulti, {
            action: buttonMulti.data('url'),
            data: {
                name: buttonMulti.data('name'),
                _token: csrfToken
            },
            name: buttonMulti.data('name'),
            onSubmit: function (file, ext) {
                buttonMulti.closest('.file-upload').find('.overlay').css({'display': 'block'});
            },
            onComplete: function (file, response) {
                setTimeout(function () {
                    buttonMulti.closest('.file-upload').find('.overlay').css({'display': 'none'});
                    response = JSON.parse(response.replace(/<.*?>/ig, ""))
                    $('.' + buttonMulti.data('name')).append('<span class="img"><img src="/images/' + response.file +
                        '" style="max-height: 150px;">' +
                        '<a class="delete close" href="/admin/product/deleteImage?t=multi&name='+ response.file+'"><i class="fa fa-fw fa-close text-danger"></i></a></span>');
                }, 1000);
            }
        });
    }
}


$(".select2").select2({
    placeholder: "Начните вводить наименование товара",
    cache: true,
    ajax: {
        url: "http://ishop.laravel/admin/product/related-product",
        delay: 250,
        dataType: 'json',
        data: function (params) {
            return {
                q: params.term,
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data.items
            };
        }
    }
});

$(document).on('mouseenter', '.img', function() {
    $(this).find('img').animate({opacity: 0.5}, 100);
    $(this).find('.close').animate({opacity: 1}, 100);
});

$(document).on('mouseleave', '.img', function() {
    $(this).find('img').animate({opacity: 1}, 100);
    $(this).find('.close').animate({opacity: 0}, 100);}
)

$(document).on('click', '.img a', function(event) {
    event.preventDefault();
    const a = event.target.closest('.img').querySelector('a');
    var el = event.target.closest('.img');
    if (a) {
        const href = a.getAttribute('href');
        console.log(href);
        $.ajax({
            url: href,
            type: 'GET',
            success: function(){
                console.log("Success!");
                el.remove();
            },
            error: function(){
                alert('Ошибка! Попробуйте позже');
            }
        });
    }
})

