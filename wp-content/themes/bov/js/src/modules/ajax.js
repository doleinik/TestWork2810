export default function () {

    $(document).ready(function () {
        $(document).ready(function () {
            $("#form__button").click(
                function () {
                    sendAjaxForm('result_form', 'wpcf7-form');
                    return false;
                }
            );
        });

        function sendAjaxForm(result_form, ajax_form) {
            $.ajax({
                url: 'https://httpbin.org/post', //url страницы (action_ajax_form.php)
                type: "POST", //метод отправки
                dataType: "html", //формат данных
                processData: false,
                data: $("." + ajax_form).serialize(),  // Сеарилизуем объект
                success: function () { //Данные отправлены успешно

                },
                error: function () { // Данные не отправлены
                    $('#result_form').html('Error');
                }
            });
        }
    });
}