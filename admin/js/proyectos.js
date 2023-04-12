const DIRECCION = 'php/Proyectos/App.php';

var tabla;
var formulario
var boton_formulario;
var boton_cancelar_formulario;
var boton_subir_imagenes;

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
    boton_subir_imagenes = $('#boton_subir_imagenes')
    
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
          });*/

          selects.each(function (e) {
              if (selects[e].value == 0 || selects[e].value == null) {
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
              editarProyecto(idEditar, inputs[0].value, selects[0].value, function () {
                  reiniciarFormulario()
              })
          }

        }
        else{

            /*inputs.each(function (e) {
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
            });*/

            selects.each(function (e) {
                if (selects[e].value == 0 || selects[e].value == null) {
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
               
                registrarProyecto(inputs[0].value, selects[0].value, function () {
                  clearInputs(inputs)
                  clearInputs(selects)
              })
            }
        }

    })

    boton_subir_imagenes.click(function(){

      let input_imagenes = $('#inp_imagenes')

      if(input_imagenes[0].files.length > 0){

        subirImagenesProyecto(input_imagenes[0].files, idEditar, function(){
          clearInputs(input_imagenes)
        })

      }
      else{
        Swal.fire({
          icon: "warning",
          title: "Campos vacíos",
          text: "No se han colocado imagenes para subir",
          timer: 1000,
          showCancelButton: false,
          showConfirmButton: false,
        });
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
                    `+
                    "<button class='btn btn-info' onclick='galeria("+JSONobject + ")' data-toggle='modal' data-target='#modal_galeria' title='Ver galería'><i class='fa-regular fa-images'></i></button>"
                    
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


function registrarProyecto(nombre_proyecto, categoria_id, callbackOnSuccess = undefined){

  /*var datasend = new FormData();


  $.each(imagenes, function (i, file) {
    datasend.append("imagenes[]", file);
  });

  datasend.append("func", "create")
  datasend.append("nombre_proyecto", nombre_proyecto)
  datasend.append("categoria_id", categoria_id)

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
  });*/

  var datasend = {
    func: "create",
    nombre_proyecto,
    categoria_id,
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


function editarProyecto(id,nombre_proyecto, categoria_id, callbackOnSuccess = undefined){

  var datasend = {
    func: "edit",
    id,
    nombre_proyecto,
    categoria_id,
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


function subirImagenesProyecto(imagenes, proyecto_id, callbackOnSuccess = undefined){

  var datasend = new FormData();

  $.each(imagenes, function (i, file) {
    datasend.append("imagenes[]", file);
  });

  datasend.append("func", "subirImagenesProyecto")
  datasend.append("proyecto_id", proyecto_id)

  Swal.fire({
    title: 'Subiendo imagenes',
    text: 'Por favor espere',
    allowOutsideClick: false,
    showCancelButton: false,
    showConfirmButton: false,
    onBeforeOpen: () => {
        Swal.showLoading()
    },
});

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
        getGaleria(response.data.proyecto_id)
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


function galeria(JSONobject){

  let proyecto_id = JSONobject.id
  let nombre_proyecto = JSONobject.nombre_proyecto
  idEditar = proyecto_id

  $('#modal_title_galeria').text("Galería " + nombre_proyecto)

  getGaleria(proyecto_id)

}


function getGaleria(proyecto_id){

  var datasend = {
    func: "imagenesProyecto",
    proyecto_id
  };

  $.ajax({
    type: "POST",
    url: 'php/Imagenes/App.php',
    dataType: "json",
    data: JSON.stringify(datasend),
    success: function (response) {

      if (response.status == "success") {

        $('#galeria-contenedor').empty()

        for (var i = 0; i < response.data.length; i++) {


          let buttonPrincipal = ""
          let JSONobject = JSON.stringify(response.data[i])

          if(response.data[i].principal == 1){
            buttonPrincipal = "<button class='btn btn-warning btn_principal' onclick='cambiarImagenPrincipal(this,"+JSONobject+")' title='Imagen principal'><i class='fa-solid fa-star'></i></button>"
          }
          else{
            buttonPrincipal = "<button class='btn btn-secondary btn_principal' onclick='cambiarImagenPrincipal(this,"+JSONobject+")'><i class='fa-solid fa-star'></i></button>"

          }


          $('#galeria-contenedor').append(`

            <div class="custom-card">

              <div class="custom-card__img">
                  <img src="../resources/proyectos/${response.data[i].nombre_imagen}" alt="Imagen" >
              </div>

              <div class="custom-card__footer">

                  ${buttonPrincipal}
                  <button class="btn btn-danger" title="Eliminar imagen" onclick='eliminar(${response.data[i].id})'><i class="fa-regular fa-trash-can"></i></button>

              </div>

            </div>
          
          `)

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

function cambiarImagenPrincipal(button, JSONobject){

  let buttons = document.getElementsByClassName("btn_principal");
  for (i = 0; i < buttons.length; i++) {
      $(buttons[i]).removeClass('btn-warning')
      $(buttons[i]).addClass('btn-secondary')
      $(buttons[i]).attr("title","")
  }
  $(button).removeClass('btn-secondary')
  $(button).addClass('btn-warning')
  $(button).attr("title","Imagen principal")

  var datasend ={
    func: 'cambiarImagenPrincipal',
    id: JSONobject.id,
    proyecto_id: JSONobject.proyecto_id
  }

  $.ajax({
    type: "POST",
    url: 'php/Imagenes/App.php',
    data: JSON.stringify(datasend),
    dataType: "json",
    success: function (response) {
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

function eliminar(id){

  Swal.fire({
    title: "¿Quieres eliminar la imagen del proyecto?",
    showCancelButton: true,
    cancelButtonText: "No",
    confirmButtonText: "Sí",
  }).then((result) => {
    if (result.isConfirmed) {

      $.ajax({
        type: "POST",
        url: 'php/Imagenes/App.php',
        data: JSON.stringify({
          func: "delete",
          id,
        }),
        dataType: "json",
        success: function (response) {
          if (response.status == "success") {

              Swal.fire({
                  icon: "success",
                  title: "Imagen eliminada",
                  timer: 1000,
                  showCancelButton: false,
                  showConfirmButton: false,
              }).then(function () {
              
                getGaleria(response.data.proyecto_id)
          
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