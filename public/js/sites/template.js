$(document).ready(function() {

    var errorElement = $('<label/>').addClass('control-label glyphicon glyphicon-remove text-danger');
    var correctElement = $('<label/>').addClass('control-label glyphicon glyphicon-ok text-success');
    // var errorMessage = '<span class="control-label glyphicon glyphicon-remove text-danger"></span>';
    var validator = $('#template-form').validate({
        // debug: true,
        rules: {
            email: 'required',
            name: {
                minlength: 2}
        },
        messages: {
            email: ' ',
            name: ' ',
            surname: ' '
        },
        onkeyup: function(element, event) {
            // console.log($(event.target).parent().next());
            next = $(event.target).parent().next();
            if ($(element).valid()) {
                if (next.length) {
                    next.remove();
                }
                correctElement.insertAfter($(element).parent());

                console.log('valid');
            } else {
                if (next.length) {
                    next.remove();
                }
                errorElement.insertAfter($(element).parent());

                console.log('INvalid');
            }
        },
        errorPlacement: function(error, element) {
            // console.log(element.parent().next());
            if (element.parent().next().length) {
                element.parent().next().remove();
            }
            error.removeClass('glyphicon-ok text-success');
            error.addClass('control-label glyphicon glyphicon-remove text-danger');
            // error.insertAfter(element.parent());
        },
        onfocusout: false,
        // errorClass: "control-label glyphicon glyphicon-remove text-danger",
        // validClass: "control-label glyphicon glyphicon-ok text-success"
        success: function(label, element) {
            if ($(element).parent().next().length) {
                $(element).parent().next().remove();
            }
            label.removeClass('glyphicon-remove text-danger');
            label.addClass('glyphicon-ok text-success');
        },
    });


})
