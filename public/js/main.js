$(document).ready(function() {

    var errorElement = $('<span/>').addClass('control-label glyphicon glyphicon-remove text-danger');
    var correctElement = $('<span/>').addClass('control-label glyphicon glyphicon-ok text-success');
    // var errorMessage = '<span class="control-label glyphicon glyphicon-remove text-danger"></span>';
    $('#template-form').validate({
        // debug: true,
        rules: {
            email: 'required',
            name: {
                minlength: 2}
        },
        messages: {
            email: ' ',
            name: ' '
        },
        errorPlacement: function(error, element) {
            // var message = error.text();
            console.log(element.parent().next());
            if (!element.parent().next('label').length) {
                error.removeClass('glyphicon-ok text-success');
                error.addClass('control-label glyphicon glyphicon-remove text-danger');
                // error.html(errorMessage);
                error.insertAfter(element.parent());
            }
        },
        // errorClass: "control-label glyphicon glyphicon-remove text-danger",
        // validClass: "control-label glyphicon glyphicon-ok text-success"
        success: function(label) {
            label.removeClass('glyphicon-remove text-danger');
            label.addClass('glyphicon-ok text-success');
        },
    });

})
