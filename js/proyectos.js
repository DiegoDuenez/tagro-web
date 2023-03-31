var categorias;
var proyectos_container;

$(document).ready(function () {

    categorias = $('#categorias')
    proyectos_container = $('#proyectos_container')

    getCategorias();
    getProyectosCategoria(null,null)
  
});
  

function getCategorias(){
    
    var datasend = {
        func: "categoriasActivas",
    };
        
    $.ajax({
    type: "POST",
    url: 'admin/php/Categorias/App.php',
    dataType: "json",
    data: JSON.stringify(datasend),
    success: function (response) {

        if (response.status == "success") {
            categorias.empty()
            for (var i = 0; i < response.data.length; i++) {

                let JSONobject = JSON.stringify(response.data[i])
                categorias.append("<div class='proyectos__categoria' onclick='getProyectosCategoria(this,"+ JSONobject +")'>" + response.data[i].nombre_categoria+"</div>")

            }
        }
    },
    error: function (e) {
        
    }
    });

}


function getProyectosCategoria(button, JSONobject){

    let buttons = document.getElementsByClassName("proyectos__categoria");
    for (i = 0; i < buttons.length; i++) {
        $(buttons[i]).removeClass('proyectos__categoria--selected')
    }
    $(button).addClass('proyectos__categoria--selected')

    
    if(JSONobject){
        var datasend ={
            func: 'proyectosCategoria',
            categoria_id: JSONobject.id
        }
    }
    else{
        var datasend ={
            func: 'proyectosCategoria',
        }
    }
    

    $.ajax({
        type: "POST",
        url: 'admin/php/Proyectos/App.php',
        data: JSON.stringify(datasend),
        dataType: "json",
        success: function (response) {

            if (response.status == "success") {
                proyectos_container.empty()
                for (var i = 0; i < response.data.length; i++) {
    
                 
                    proyectos_container.append(`
                        <div class="proyectos__card" data-aos="fade-up" id="${response.data[i].id}">

                            <img src="resources/proyectos/${response.data[i].nombre_imagen}" alt="" class="proyectos__card-img">
            
                            <div class="proyectos__card-footer">
                                <div class="proyectos__card-title">
                                    ${response.data[i].nombre_categoria}
                                </div>
                                
                                <div class="proyectos__card-text">
                                    ${response.data[i].nombre_proyecto}
                                </div>
                            </div>
            
                        </div>
                    `)

    
                }

                const modal = new Menu({options: {element: '.modal__container', openWith: '.proyectos__card', closeWith: '#btn-modal-close', from: 'bottom',
                    callbackOnOpen: function(){
                        let modal_back= document.querySelector('.modal')
                        modal_back.style.visibility = 'visible'

                        let body = document.querySelector('body')
                        body.style.overflow = 'hidden'

                        getGaleria($(modal.elementClicked).attr('id'))



                    },
                    callbackOnClose: function(){
                        let modal = document.querySelector('.modal')
                        modal.style.visibility = 'hidden'
                        let body = document.querySelector('body')
                        body.style.overflow = 'auto'
                    }  
                }})
                modal.init()
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


function getGaleria(proyecto_id){

    var datasend = {
      func: "imagenesProyecto",
      proyecto_id
    };
  
    $.ajax({
      type: "POST",
      url: 'admin/php/Imagenes/App.php',
      dataType: "json",
      data: JSON.stringify(datasend),
      success: function (response) {
  
        if (response.status == "success") {
  
            $('#galeria-contenedor').empty()

            $('#modal-titulo').text(response.data[0].nombre_proyecto)
            $('#modal-texto').text(response.data[0].nombre_categoria)

  
            for (var i = 0; i < response.data.length; i++) {

                $('#galeria-contenedor').append(`
                    <div class="swiper-slide">
                        <img src="resources/proyectos/${response.data[i].nombre_imagen}" alt="Imagen" class="modal__img">
                    </div>    
                `)
  
            }

            const swiper = new Swiper('.swiper', {
                direction: 'horizontal',
                loop: true,
                autoplay: {
                    delay: 2000,
                },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
    
        });
  
        }
      },
      error: function (e) {
        
      },
    });
  
  }
  