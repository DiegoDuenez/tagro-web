<!DOCTYPE html>
<html lang="en">

<head>
    
    <title>TAGRO | Categorías</title>
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
                                    <h3 class="card-title"><i class="fa-solid fa-grid-2"></i> Categorías registradas</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table w-100" id="tabla">
                                        <thead>
                                            <tr>
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
                                    <h3 class="card-title" id="formulario_titulo">Registrar categoría</h3>
                                </div>
                                <div class="card-body">

                                    <form id="formulario">
                        
                                        <div class="form-group mt-2">
                                            <label for="inp_categoria">Nombre categoria <span class="text-danger" title="Campo obligatorio">*</span></label>
                                            <input class="form-control" id="inp_categoria" placeholder="Nombre categoria" required />
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
    <script src="js/categorias.js"></script>


</body>

</html>