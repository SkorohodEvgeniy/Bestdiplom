$('document').ready(function () {
    $(".confirmable-pass").keyup(function() {
        var value = $(this).val();
        var confirmed = true;
        $(".confirmable-pass").each(function(item) {
            if(value !== $(this).val()) {
                $('.passErr').html('Passwords Don\'t Match');
                confirmed = false;
            }
            if(value.length < 6){
                $('.passErr').html('Password lenght must be more than 6 symbols');
                confirmed = false;

            }
        });
        if(confirmed) {
            $(".confirmable-pass").css({"border": "none", "box-shadow": 'none'});
            $('input[type="submit"]').removeAttr('disabled');
            $( ".passErr" ).html('');
        } else {
            $(".code2").css({"border": "1px solid #f00", 'box-shadow': '0 0 10px rgba(255, 0, 0, 0.5)'});
            $('input[type="submit"]').attr('disabled', 'disabled');

        }
    });
});
