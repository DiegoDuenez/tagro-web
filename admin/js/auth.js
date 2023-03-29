


$(document).ready(function(){
    authGuard()
})

  /*
if (localStorage.getItem("usuario") !== null) {
    var usuario = JSON.parse(localStorage.getItem("usuario"));
    $("#usuario").html(`<a href='usuarios.php' style='font-weight: normal;'><i class="fa-solid fa-circle-user" title='${usuario.usuario}'></i> ${usuario.usuario}</a> `);
}*/

function logout() {

    if (loggedIn()) {
        localStorage.removeItem("usuario");
        localStorage.removeItem("id");
        window.location = "index.php";
    }

}

function loggedIn() {
    return !!localStorage.getItem("usuario");
}

function authGuard() {
    if (loggedIn()) {
        return true;
    } else {
        window.location = "index.php";
        return false;
    }
}