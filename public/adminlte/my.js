$('#editor1').ckeditor();

$('.delete').click(function () {
    var res = confirm('Подтвердите действие');
    if (!res) {
        return false;
    }
});

$('.sidebar-menu a').each(function () {
    var loc = window.location.protocol + '//' + window.location.host + window.location.pathname;
    var link = this.href;

    if (link == location) {
        $(this).parent().addClass('active');
        $(this).closest('.treeview').addClass('active');
    }
});


if ($('div').is('#single')) {
    var buttonSingle = $("#single"),
        buttonMulti = $("#multi"),
        file;

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
}

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
                $('.' + buttonSingle.data('name')).html('<img src="/images/' + response.file + '" style="max-height: 150px;">');
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
                response = JSON.parse(response.replace(/<.*?>/ig, ""));
                $('.' + buttonMulti.data('name')).append('<img src="/images/' + response.file + '" style="max-height: 150px;">');
            }, 1000);
        }
    });
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
