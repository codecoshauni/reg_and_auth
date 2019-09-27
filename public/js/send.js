$( document ).ready(function() {
    $("#btn").on('click', function(e){
            e.preventDefault();

            ajaxUrl = $('form').attr('class') == 'form-auth' ? '/auth' : '/';
            formClass = $('form').attr('class')
            sendAjaxForm('result_form', formClass, ajaxUrl);
            return false;
    });
});

function sendAjaxForm(ajax_form, url) {
    $.ajax({
        url: url,
        type: "POST",
        data: $("."+ajax_form).serialize(),
        success: function(response) {
            result = $.parseJSON(response);
        }
    });
}