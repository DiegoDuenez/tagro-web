<!DOCTYPE html>
<html lang="en">

<head>
    
    <title>TAGRO | Proyectos</title>
    <?php include 'templates/header.php'; ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include 'templates/navbar.php' ?>
        <?php include 'templates/sidebar.php' ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">

                    <div class="row p-3 pt-5">
                        <div class="col-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa-solid fa-folder"></i> Proyectos registrados</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table w-100" id="tabla">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Proyecto</th>
                                                <th scope="col" class="text-center">Categoría</th>
                                                <th scope="col" class="text-center">Estatus</th>
                                                <th scope="col" class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title" id="formulario_titulo">Registrar proyecto</h3>
                                </div>
                                <div class="card-body">

                                    <form id="formulario">
                        
                                        <div class="form-group mt-2">
                                            <label for="inp_proyecto">Nombre proyecto <span class="text-danger" title="Campo obligatorio">*</span></label>
                                            <input class="form-control" id="inp_proyecto" placeholder="Nombre proyecto" required />
                                        </div>

                                        <div class="form-group mt-2">
                                            <label for="select_categoria">Categoría <span class="text-danger" title="Campo obligatorio">*</span></label>
                                            <select class="form-control" name="categoria" id="select_categoria"></select>
                                        </div>
                                        
                                        <div class="form-group mt-2">
                                            <label for="inp_imagenes">Imagenes <span class="text-danger" title="Campo obligatorio">*</span></label>
                                            <input class="form-control-file imagenes" id="inp_imagenes" placeholder="Imagenes" type="file" multiple required />
                                        </div>

                                    </form>

                                    <div class="d-flex justify-content-end" style="gap: 1rem">
                                        <button type="button" class="btn btn-secondary d-none" id="boton_cancelar_formulario">Cancelar</button>
                                        <button type="button" class="btn btn-success" id="boton_formulario">Registrar</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'templates/footer.php' ?>
    </div>

    <?php include 'templates/scripts.php' ?>
    <script src="js/auth.js"></script>
    <script src="js/proyectos.js"></script>


</body>

</html>