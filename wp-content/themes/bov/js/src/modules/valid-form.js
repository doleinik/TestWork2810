export default function () {
    $(document).ready(function () {
        $('.wpcf7-form').on('submit', function (event) {
            if (validateForm()) { // если есть ошибки возвращает true
                event.preventDefault();
            }
        });

        $('#form__button').click(function () {
            let checkEmail = $("input[name='your-email']").val();
            if (checkEmail.length !== 0) {
                let testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                if (testEmail.test(checkEmail)) {
                    $('#form__button').removeAttr('disabled');
                    $('#result_form').text('Success');
                } else {
                    $('#label__email').css({"border-bottom-color":"red"});
                    $('#result_form').text('Error in entering mail!');
                }


            } else {
                $('#form__button').attr('disabled', 'disabled');
                $('#result_form').text('Is there something wrong!');
            }
        });

        $('#form__button').mouseover(function () {
            let inputs = $('.form__input');
            for (let i = 0; i < inputs.length; i++) {
                let check = inputs[i].value;
                if (check.length !== 0) {
                    $('#form__button').removeAttr('disabled');
                } else {
                    $('#form__button').attr('disabled', 'disabled');
                }
            }
        });
    });
}