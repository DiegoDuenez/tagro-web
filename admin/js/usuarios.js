const DIRECCION = 'php/Usuarios/App.php';

var tabla;
var formulario
var boton_formulario;
var boton_cancelar_formulario;

var editar = false;
var formulario_titulo;
var idEditar = 0;
var lb_contrasenia;

$(document).ready(function () {

  initElements();

});


function initElements(){

    formulario = $('#formulario')
    boton_formulario = $('#boton_formulario')
    formulario_titulo = $('#formulario_titulo')
    boton_cancelar_formulario = $('#boton_cancelar_formulario')
    lb_contrasenia = $('#lb_contrasenia')
    
    tabla = $("#tabla").DataTable({
        pageLength: 5,
        lengthMenu: [
            [5, 10, 20, -1],
            [5, 10, 20, "Todos"],
        ],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontro ningún registro",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            sSearch: "Buscar",
            paginate: {
            previous: "Anterior",
            next: "Siguiente",
            },
        },
    });
    
    boton_cancelar_formulario.click(function(){

       reiniciarFormulario()
    
    })

    boton_formulario.click(function(){

        let inputs = formulario.find('input')
        var dataValid = true;

        if(editar){

            inputs.each(function (e) {
                if (inputs[0].value == "" || inputs[0].value == null) {
                  Swal.fire({
                    icon: "warning",
                    title: "Campos vacíos",
                    text: "Necesitas llenar todos los campos",
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false,
                  });
                  dataValid = false;
                }
            });

            if (dataValid) {
                editarUsuario(idEditar, inputs[0].value, inputs[1].value, function () {
                    reiniciarFormulario()
                })
            }
        }
        else{
            
            inputs.each(function (e) {
                if (inputs[e].value == "" || inputs[e].value == null) {
                  Swal.fire({
                    icon: "warning",
                    title: "Campos vacíos",
                    text: "Necesitas llenar todos los campos",
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false,
                  });
                  dataValid = false;
                }
            });

            if (dataValid) {
                registrarUsuario(inputs[0].value, inputs[1].value, function () {
                    clearInputs(inputs)
                })
            }
        }

    })

    getUsuarios()

}


function getUsuarios(){

    $.blockUI({
        message: "<h4> TRAYENDO USUARIOS...</h4>",
        css: { backgroundColor: null, color: "#fff", border: null },
      });
    
      var datasend = {
        func: "index",
      };
    
      $.ajax({
        type: "POST",
        url: DIRECCION,
        dataType: "json",
        data: JSON.stringify(datasend),
        success: function (response) {

          if (response.status == "success") {
    
            tabla.clear();
    
            for (var i = 0; i < response.data.length; i++) {


                let status;
                let JSONobject = JSON.stringify(response.data[i])

                if (response.data[i].status == 1) {
                    status = '<span class="badge badge-success">Activo</span>';
                } else if (response.data[i].status == 0) {
                    status = '<span class="badge badge-danger">Inactivo</span>';
                }

                tabla.row.add([
                    response.data[i].usuario,
                    status,
                    "<button class='btn btn-warning' title='Editar usuario' onclick='llenarFormulario(" +JSONobject + ")'><i class='fa-solid fa-pen-to-square' ></i></button>"+
                    `
                    ${
                        response.data[i].status == 1
                            ? `<button class="btn btn-danger btn_eliminar_usuario" onclick="desactivar( ${response.data[i].id})" title="Desactivar usuario"><i class="fa-solid fa-ban" ></i></button>`
                            : `<button class="btn btn-success btn_activar_usuario" onclick="activar(${response.data[i].id})" title="Activar usuario"><i class="fa-regular fa-circle-check"></i></button>`
                        }
                    `
                ]);

            }
            tabla.draw();
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


function llenarFormulario(JSONobject){

    editar = true

    boton_cancelar_formulario.removeClass('d-none')
    boton_formulario.text("Guardar")
    formulario_titulo.text("Editar usuario")
    lb_contrasenia.addClass("d-none")

    let inputs = formulario.find('input')

    inputs[0].value = JSONobject.usuario
    idEditar = JSONobject.id

}

function editarUsuario(id, usuario, contrasenia = null, callbackOnSuccess = undefined){

    if(contrasenia){
        var datasend = {
            func: "edit",
            id,
            usuario,
            contrasenia,
        };
    }
    else{
        var datasend = {
            func: "edit",
            id,
            usuario
        };
    }

    $.ajax({

        type: "POST",
        url: DIRECCION,
        dataType: "json",
        data: JSON.stringify(datasend),
        success: function (response) {

          if (typeof callbackOnSuccess == "function") callbackOnSuccess();
    
          Swal.fire({
            icon: "success",
            title: response.message,
            timer: 1000,
            showCancelButton: false,
            showConfirmButton: false,
          }).then(function () {
            
            getUsuarios();
        
            });

        },
        error: function (e) {
          if ("responseJSON" in e) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: e.responseJSON.message,
            });
          } else {
            Swal.fire({
              icon: "error",
              input: "textarea",
              inputValue: e.responseText,
              title: "Oops...",
              text: "Error Interno del Servidor",
            });
          }
        },
        complete: function () {
          $.unblockUI();
        },
    });
    
}

function registrarUsuario(usuario, contrasenia = null,callbackOnSuccess = undefined){

    var datasend = {
        func: "create",
        usuario,
        contrasenia,
    };

    $.ajax({
        type: "POST",
        url: DIRECCION,
        dataType: "json",
        data: JSON.stringify(datasend),
        success: function (response) {

          
          if (typeof callbackOnSuccess == "function") callbackOnSuccess();
    
          Swal.fire({
            icon: "success",
            title: response.message,
            timer: 1000,
            showCancelButton: false,
            showConfirmButton: false,
          }).then(function () {
            
            getUsuarios();
        
            });

        },
        error: function (e) {
          if ("responseJSON" in e) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: e.responseJSON.message,
            });
          } else {
            Swal.fire({
              icon: "error",
              input: "textarea",
              inputValue: e.responseText,
              title: "Oops...",
              text: "Error Interno del Servidor",
            });
          }
        },
        complete: function () {
          $.unblockUI();
        },
    });
    
}


function reiniciarFormulario(){
    editar = false
    idEditar = 0
    boton_cancelar_formulario.addClass('d-none')
    boton_formulario.text("Registrar")
    formulario_titulo.text("Registrar usuario")
    lb_contrasenia.removeClass("d-none")
    let inputs = formulario.find('input')
    clearInputs(inputs)
}


function desactivar(id) {

  Swal.fire({
    title: "¿Quieres desactivar al usuario?",
    showCancelButton: true,
    cancelButtonText: "No",
    confirmButtonText: "Sí",
  }).then((result) => {
    if (result.isConfirmed) {

      $.ajax({
        type: "POST",
        url: DIRECCION,
        data: JSON.stringify({
          func: "desactivar",
          id,
        }),
        dataType: "json",
        success: function (response) {
          if (response.status == "success") {
            

              Swal.fire({
                  icon: "success",
                  title: "Usuario desactivado",
                  timer: 1000,
                  showCancelButton: false,
                  showConfirmButton: false,
              }).then(function () {
              
                  getUsuarios();
          
              });

          }
        },
        error: function (e) {
          if ("responseJSON" in e) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: e.responseJSON.message,
            });
          } else {
            Swal.fire({
              icon: "error",
              input: "textarea",
              inputValue: e.responseText,
              title: "Oops...",
              text: "Error Interno del Servidor",
            });
          }
        },
      });
    }
  });
}
  
function activar(id) {
    Swal.fire({
      title: "¿Quieres activar al usuario?",
      showCancelButton: true,
      cancelButtonText: "No",
      confirmButtonText: "Sí",
    }).then((result) => {

      if (result.isConfirmed) {

        $.ajax({
          type: "POST",
          url: DIRECCION,
          data: JSON.stringify({
            func: "activar",
            id,
          }),
          dataType: "json",
          success: function (response) {

            if (response.status == "success") {
  
                Swal.fire({
                    icon: "success",
                    title: "Usuario activado",
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false,
                }).then(function () {
                    
                    getUsuarios();
            
                });

            }

          },
          error: function (e) {
            if ("responseJSON" in e) {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: e.responseJSON.message,
              });
            } else {
              Swal.fire({
                icon: "error",
                input: "textarea",
                inputValue: e.responseText,
                title: "Oops...",
                text: "Error Interno del Servidor",
              });
            }
          },
        });
      }
    });
}