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
        func: "index",
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
                        <div class="proyectos__card" data-aos="fade-up">

                            <img src="resources/proyectos/${response.data[i].nombre_imagen}" alt="" class="proyectos__card-img">
            
                            <div class="proyectos__card-footer">
                                <div class="proyectos__card-title">
                                    ${response.data[i].nombre_proyecto}
                                </div>
                                
                                <div class="proyectos__card-text">
                                    ${response.data[i].nombre_categoria}
                                </div>
                            </div>
            
                        </div>
                    `)
                  
    
                }
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