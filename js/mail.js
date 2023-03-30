function enviar() {

    var response = grecaptcha.getResponse();
    if (response.length != 0) {

        const nombre = $("#nombre").val()
        const correo = $("#email").val()
        const telefono = $("#telefono").val()
        const mensaje = $("#mensaje").val()

        if(nombre != "" && correo != "" && mensaje != "" && telefono != ""){
            $.ajax({
                url: 'config/mail.php',
                type: 'post',
                data: {'nombre': nombre, 'correo': correo, 'mensaje': mensaje, 'telefono': telefono},
                dataType: 'text',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                success: function (response) {
                    $("#nombre").val('')
                    $("#email").val('')
                    $("#telefono").val('')
                    $("#mensaje").val('')
                    document.getElementById('status').style.display = 'none'
                    Swal.fire(
                        {
                        title: "Gracias por enviarnos tu correo",
                        text: "Espera nuestra respuesta pronto",
                        icon: 'success',
                        confirmButtonText: "Ok",
                        iconColor: '#f1790d',
                        confirmButtonColor: "#f1790d",
                        }
                    )
                
                },
                error: function(xhr, status, error) {
                    $("#nombre").val('')
                    $("#correo").val('')
                    $("textarea#mensaje").val('')
                    document.getElementById('status').style.display = 'none'

                    
                }
            });
        }
        else{
            Swal.fire(
                {
                title: "Fallo al enviar email",
                text: "Debes de llenar todos los campos",
                icon: 'error',
                confirmButtonText: "Ok",
                iconColor: 'red',
                confirmButtonColor: "red",
                }
            )
        }

    }
    else {
        document.getElementById('status').style.display = 'block'
        document.getElementById('status').innerHTML = "¡Debes aceptar el captcha!";
        $('#status').css('color','black').css('font-size','1rem');
    }

    
}