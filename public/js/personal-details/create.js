'use strict';

(function($) {
    $(function() {
        $( "#personal-details-form" ).submit(function(event) {
            var _this = this;
            event.preventDefault();
            $.post('/personal-details/create', $(_this).serializeArray(), function(data) {
                console.log(data);
                window.location = '/personal-details';
            }, 'json').fail(function(error) {
                console.log(error);
                if (error.status == 422) {
                    var errors = error.responseJSON;
                    for (var field in errors) {
                        var elem = $('#error-' + field);
                        if (elem.length) {
                            // remove previous error
                            elem.html('');
                            // add new errors
                            errors[field].forEach(function(message) {
                                elem.append('<li>' + message + '</li>');
                            });
                        }
                    }
                }
            });
        });
    });
})(jQuery);
