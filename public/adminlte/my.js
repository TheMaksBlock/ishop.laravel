CKEDITOR.replace('editor1');

$('.delete').click(function(){
    var res = confirm('Подтвердите действие');
    if(!res) {
        return false;
    }
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
