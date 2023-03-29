const DIRECCION = 'php/Proyectos/App.php';

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
        let selects = formulario.find('select')
        let inputs_file = formulario.find('input.imagenes')

        var dataValid = true;

        if(editar){

            /*inputs.each(function (e) {
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
                editarProyecto(idEditar, inputs[0].value, inputs[1].value, function () {
                    reiniciarFormulario()
                })
            }*/
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

            selects.each(function (e) {
                if (selects[e].value == "" || selects[e].value == null) {
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
                registrarProyecto(inputs[0].value, selects[0].value, inputs_file[0].files, function () {
                    clearInputs(inputs)
                    clearInputs(selects)

                })
            }
        }

    })

    
    $(`#select_categoria`).select2({
        theme: "bootstrap4",
        width: "100%",
    });

    getProyectos()
    getCategorias()

}



function getProyectos(){

    $.blockUI({
        message: "<h4> TRAYENDO PROYECTOS...</h4>",
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
                    response.data[i].nombre_proyecto,
                    response.data[i].nombre_categoria,
                    status,
                    "<button class='btn btn-warning' title='Editar proyecto' onclick='llenarFormulario(" +JSONobject + ")'><i class='fa-solid fa-pen-to-square' ></i></button>"+
                    `
                    ${
                        response.data[i].status == 1
                            ? `<button class="btn btn-danger" onclick="desactivar( ${response.data[i].id})" title="Desactivar proyecto"><i class="fa-solid fa-ban" ></i></button>`
                            : `<button class="btn btn-success" onclick="activar(${response.data[i].id})" title="Activar proyecto"><i class="fa-regular fa-circle-check"></i></button>`
                        }
                        <button class="btn btn-info" onclick="galeria(${response.data[i].id})" title="Ver galería"><i class="fa-regular fa-images"></i></button>
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

function getCategorias(){

      var datasend = {
        func: "categoriasActivas",
      };
    
      $.ajax({
        type: "POST",
        url: 'php/Categorias/App.php',
        dataType: "json",
        data: JSON.stringify(datasend),
        success: function (response) {

          if (response.status == "success") {
    
            $(`#select_categoria`).empty()
            $("#select_categoria").append(`<option value="0" >Seleccionar categoría</option>`);

            for (var i = 0; i < response.data.length; i++) {
                
                $("#select_categoria").append(`
                    <option name="${response.data[i].nombre_categoria}" value="${response.data[i].id}">${response.data[i].nombre_categoria}</option>
                `);
                
            }

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
    });

}

function llenarFormulario(JSONobject){

  editar = true

  boton_cancelar_formulario.removeClass('d-none')
  boton_formulario.text("Guardar")
  formulario_titulo.text("Editar proyecto")

  let inputs = formulario.find('input')
  let selects = formulario.find('select')

  inputs[0].value = JSONobject.nombre_proyecto
  selects.val(JSONobject.categoria_id)
  selects.trigger('change');

  idEditar = JSONobject.id

}

function reiniciarFormulario(){
  editar = false
  idEditar = 0
  boton_cancelar_formulario.addClass('d-none')
  boton_formulario.text("Registrar")
  formulario_titulo.text("Registrar proyecto")
  let inputs = formulario.find('input')
  let selects = formulario.find('select')

  clearInputs(inputs)
  clearInputs(selects)

}


function registrarProyecto(nombre_proyecto, categoria_id, imagenes, callbackOnSuccess = undefined){

  var datasend = new FormData();


  $.each(imagenes, function (i, file) {
    datasend.append("imagenes[]", file);
  });

  datasend.append("func", "create")
  datasend.append("nombre_proyecto", nombre_proyecto)
  datasend.append("categoria_id", categoria_id)
 // datasend.append("imagenes", imagenes)

  $.ajax({
    url: DIRECCION,
    data: datasend,
    cache: false,
    contentType: false,
    processData: false,
    type: "POST",
    success: function (response) {

        if (typeof callbackOnSuccess == "function") callbackOnSuccess();

        Swal.fire({
            icon: "success",
            title: response.message,
            timer: 1000,
            showCancelButton: false,
            showConfirmButton: false,
        }).then(function () {
            
            getProyectos()
        
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



function desactivar(id) {

  Swal.fire({
    title: "¿Quieres desactivar el proyecto?",
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
                  title: "Proyecto desactivado",
                  timer: 1000,
                  showCancelButton: false,
                  showConfirmButton: false,
              }).then(function () {
              
                  getProyectos()
          
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
    title: "¿Quieres activar el proyecto?",
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
                  title: "Proyecto activado",
                  timer: 1000,
                  showCancelButton: false,
                  showConfirmButton: false,
              }).then(function () {
                  
                  getProyectos();
          
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