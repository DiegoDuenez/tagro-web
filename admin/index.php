<!DOCTYPE html>
<html lang="en">

<head>
    
    <title>TAGRO | Iniciar sesión</title>
    <?php include 'templates/header.php'; ?>

</head>

<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">
            <span class="fw-bold h1">
                <img src="../resources/logo_oscuro.png" alt="TAGRO" class="" title="TAGRO" style="width: 15rem;">
            </span>
        </div>
        <div class="card rounded-3 card-outline card-primary shadow">
            <div class="card-body login-card-body">
                <p class="login-box-msg text-sm fst-italic">Ingresa tus datos para iniciar sesión</p>

                <form id="formulario_login" onsubmit="return false">
                    <input type="hidden" id="accion" value="iniciar_sesion">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control rounded-l" id='usuario' name='usuario' placeholder="Usuario" aria-label="Username" aria-describedby="span-usuario" autofocus="autofocus" />
                        <span class="input-group-text" id="span-usuario"><i class="fa-solid fa-user"></i></span>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id='contrasenia' name='contrasenia' placeholder="Contraseña" aria-label="Contrasenia" aria-describedby="span-contrasenia" autocomplete="off" onkeypress="keyLogin()" />
                        <span class="input-group-text" id="span-contrasenia"><i class="fa-solid fa-key"></i></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-outline-primary btn-block fw-bold text-center" id="btnIniciarsesion" onclick="iniciarSesion()">
                                <i class="fa-solid fa-circle-arrow-right"></i>&nbsp;INGRESAR
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'templates/scripts.php' ?>
    <script src="js/index.js"></script>

</body>

</html>