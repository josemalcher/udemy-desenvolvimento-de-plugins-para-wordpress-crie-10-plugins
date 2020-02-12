jQuery(document).ready(function ($) {
    $("#subscriber-form").submit(function (e) {

        e.preventDefault();

        let subscriberData = $("#subscriber-form").serialize();
        let url = $("#subscriber-form").attr('action');
        console.log(url);
        console.log(subscriberData);

        let name = $("#name").val();
        let email = $("#email").val();
        let recipient = $("#recipient").val();
        let subject = $("#subject").val();
        console.log(name, email, recipient, subject);

        $.ajax({
            type: 'post',
            url: url,
            data: { name: name, email:email, recipient:recipient, subject: subject}
        }).done(function (response) {
            $("#form-msg").text(response);
            $("#name").val('');
            $("#email").val('');

        }).fail(function (data) {
            if(data.response !== ''){
                $("#form-msg").text(data.response);
            }else{
                $("#form-msg").text("A mensagem não foi enviada");
            }

        });
    });
});