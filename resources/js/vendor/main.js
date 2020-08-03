$(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
    
    $(".conf_form").submit(function(event){
        var form = $(this);
        event.preventDefault();
        $("#confirm_modal").modal('show');
        $('#confirm_modal .btn_conf').on('click', function(){
            $(form).unbind().submit();
        })
    });
});