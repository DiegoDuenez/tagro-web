
const servicios__item = document.querySelectorAll(".servicios__materiales-menu-item");
const servicio_title = document.querySelector("#servicio-title")

for (let i = 0; i < servicios__item.length; i++) {

    servicios__item[i].addEventListener('click', function (event) {

        let element = document.querySelector("#"+this.getAttribute("data-item"))
        let elements = document.querySelectorAll(".servicios__materiales-descripcion")

        servicio_title.innerHTML = this.getAttribute("data-title")

        /*let childElement = servicios__item[i].querySelector('#servicio_material')
        childElement.style.borderLeft = "3px var(--celeste) solid"
        childElement.style.color = "var(--azul)"*/

        elements.forEach(function(e){
            e.style.display = "none"
        })

        if (element.style.display == "none") {
            element.style.display = "flex"
        }

        
    })
}