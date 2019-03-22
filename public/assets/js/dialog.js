$('body').delegate('a[target=ajax-modal],button[target=ajax-modal]','click',function(){
    var url = $(this).attr('href');
    ajaxModal(url,$(this));
    return false;
});

$('body').delegate('a[target=print],button[target=print],a.print','click',function(){
    var url = $(this).attr('href');
    print(url);
    return false;
});

urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
        return null;
    }
    else{
        return results[1] || 0;
    }
}

$('body').delegate('a.hapus','click',function(event){
    if($(this).data('method') === 'delete') {
        // alert($(this).attr('title'));
        event.preventDefault();
        console.log($(this).attr('href'));
        // $("#hapus-data .ok").attr('href', $(this).attr('href'));
        $("#hapus-data .del").attr('action', $(this).attr('href'));
        if($(this).attr('message')!=null)
            $('#pesan-dialog').html($(this).attr('message'));
        $("#hapus-data").modal('show');
        $('#trash-ck').hide();
        if(urlParam('status')=='trash'){
            $('#trash-ck').hide();
        }
        $('#trash-ck').show();
    }
    return false;
});
function print(url){
    window.open(url,'popUpWindow','height=600,width=900,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
}
function ajaxModal(url,el){
    $('#myModelDialog').css({'width':''});
    // $('.modal-dialog').addClass('modal-lg');

    if($(el).hasClass('modal-max')){
     // $('#myModelDialog').addClass('modal-max');
        $('#myModelDialog').css({'width':'900px'});
        console.log('tess');
    }

    $('#myModelDialog').html();
    $.ajax({
        url: url,
        data:'ajax=1',
        cache: false,
        dataType: 'html',
        success: function(msg){
            $('#myModelDialog').html(msg);
            $('#myModelDialog').modal({backdrop: 'static'});
        },
        error: function(){
            $('#myModelDialog').html("request gagal dibuka");
            $('#myModelDialog').modal('show');
            console.log('gagal');
        }
    });
    return true;
}
function confirmDeleteDialog(dialogText,el){
    bootbox.confirm(dialogText, function(result) {
        if(result){
            $(el).parents('form').submit();
        }
    });
    return false;
}


$(function(){
    //check all data table selected
    $(".check_all").click(function() {
        var check_semua = this.checked;
        $(".checkall").each(function()
        {
            this.checked = check_semua;
        });

    });

    // confirm delete all begin
    $('.aksi').click(function(event) {
        event.preventDefault();
        var title = $(this).children(':selected').data('title');
        var content = $(this).children(':selected').data('content');
        $('.modal-title').html(title);
        $('.modal-body p').html(content);
    });


    $('.delete-event').click(function(event) {
        event.preventDefault();

        $('#event-delete').modal('show');

        $('.yes').click(function(event) {
            console.log("kesini berhasil");
            $('#dell_all').submit();
            $('#event-delete').modal('toggle');
        });
    });
    // end

    $('.close').click(function(){
        $('.ext').hide();
    });


    // $(".valid").validate();
    // $(".reset").validate();

    // $("#tags").val();
    // $("#tags").tagsinput();

});
var toastCount=0;
function alertToastr(message,titleParam,typeGroup){
    var shortCutFunction = typeGroup;
    var msg = message;
    var title = titleParam || '';
    var toastIndex = toastCount++;

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-bottom-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    if ($('#addBehaviorOnToastClick').prop('checked')) {
        toastr.options.onclick = function () {
            alert('You can perform some custom action after a toast goes away');
        };
    }

    if (!msg) {
        msg = getMessage();
    }

    $("#toastrOptions").text("Command: toastr[" + shortCutFunction + "](\"" + msg + (title ? "\", \"" + title : '') + "\")\n\ntoastr.options = " + JSON.stringify(toastr.options, null, 2));

    var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
    $toastlast = $toast;
    if ($toast.find('#okBtn').length) {
        $toast.delegate('#okBtn', 'click', function () {
            alert('you clicked me. i was toast #' + toastIndex + '. goodbye!');
            $toast.remove();
        });
    }
    if ($toast.find('#surpriseBtn').length) {
        $toast.delegate('#surpriseBtn', 'click', function () {
            alert('Surprise! you clicked me. i was toast #' + toastIndex + '. You could perform an action here.');
        });
    }

    $('#clearlasttoast').click(function () {
        toastr.clear($toastlast);
    });
}