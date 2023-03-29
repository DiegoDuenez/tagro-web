const DIRECCION = 'php/Usuarios/App.php';

function iniciarSesion(){

    let usuario = $('#usuario').val()
    let contrasenia = $('#contrasenia').val()

    if (usuario == "" || contrasenia == "") {

        Swal.fire({
          icon: "warning",
          title: "Campos vacíos",
          text: "Necesitas llenar todos los campos",
        });

      } else {

        $.blockUI({
          message: "<h4> REALIZANDO PETICIÓN...</h4>",
          css: { backgroundColor: null, color: "#fff", border: null },
        });
    
        var datasend = {
          func: "login",
          usuario,
          contrasenia,
        };
    
        $.ajax({
          type: "POST",
          url: DIRECCION,
          dataType: "json",
          data: JSON.stringify(datasend),
          success: function (response) {
            if (response.status == "success") {

  
              localStorage.setItem("usuario", JSON.stringify(response.data.usuario));
              localStorage.setItem("id", JSON.stringify(response.data.id));
  
              Swal.fire({
                icon: "success",
                title: `Bienvenid@ ${response.data.usuario}`,
                allowOutsideClick: false,
                timer: 1000,
                showCancelButton: false,
                showConfirmButton: false,
              }).then(function () {
                window.location = "usuarios.php";
              });
  
            }
          },
          error: function (e) {
            if('responseJSON' in e){
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: e.responseJSON.message,
              });
            }
            else{
              Swal.fire({
                icon: "error",
                input: 'textarea',
                inputValue: e.responseText,
                title: "Oops...",
                text: 'Error Interno del Servidor',
              });
            }
          },
          complete: function () {
            $.unblockUI();
          },

        });
    }

}


function keyLogin() {
    if (window.event.keyCode == 13) {
      iniciarSesion();
    }
}