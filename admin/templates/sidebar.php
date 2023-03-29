<?php

$ruta = basename($_SERVER['PHP_SELF']);



?>

<aside class="main-sidebar sidebar-light-secondary elevation-4">
    <a href="usuarios.php" class="brand-link" style="display: flex; justify-content:center" >
        <img src="../resources/logo_oscuro.png" alt="TAGRO" class="brand-image" title="TAGRO" >
        <br>
        <span span class="brand-text font-weight-light  d-none">TAGRO</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            </div>
            <div class="info">
                <a href="#" class="d-block" id="usuario">... </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview menu-open ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa-solid fa-book"></i>
                        <p>
                            Catálogos
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <li class="nav-item " id="usuarios">
                                <a href="perfiles.php" class="nav-link <?php if ($ruta == 'usuarios.php') echo ' active'; ?>">
                                <i class="fa-solid fa-users"></i>
                                    <p>Usuarios</p>
                                </a>
                            </li>
                            <li class="nav-item " id="usuarios">
                                <a href="perfiles.php" class="nav-link <?php if ($ruta == 'categorias.php') echo ' active'; ?>">
                                <i class="fa-solid fa-grid-2"></i>
                                    <p>Categorias</p>
                                </a>
                            </li>
                            <li class="nav-item " id="usuarios">
                                <a href="perfiles.php" class="nav-link <?php if ($ruta == 'proyectos.php') echo ' active'; ?>">
                                    <i class="fa-solid fa-folder"></i>
                                    <p>Proyectos</p>
                                </a>
                            </li>
                            
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview ">
                    <a href="#" class="nav-link d-none " id="ReportesMenu">
                        <i class="nav-icon fa-solid fa-chart-line"></i>
                        <p>
                            Reportes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <li class="nav-item d-none" id="Registro_de_credito">
                                <a href="registro-credito.php" class="nav-link <?php if ($ruta == 'registro-credito.php') echo ' active'; ?>">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                    <p>Registro de crédito</p>
                                </a>
                            </li>
                            <li class="nav-item d-none" id="Cobranza">
                                <a href="cobranza.php" class="nav-link <?php if ($ruta == 'cobranza.php') echo ' active'; ?>">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                    <p>Cobranza</p>
                                </a>
                            </li>
                            <li class="nav-item d-none" id="Estimados">
                                <a href="estimados.php" class="nav-link <?php if ($ruta == 'estimados.php') echo ' active'; ?>">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                    <p>Estimados</p>
                                </a>
                            </li>
                            <li class="nav-item d-none" id="Reporte_diario_de_rutas">
                                <a href="reporte-diario.php" class="nav-link <?php if ($ruta == 'reporte-diario.php') echo ' active'; ?>">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                    <p>Diario de rutas</p>
                                </a>
                            </li>
                            <li class="nav-item d-none" id="Reporte_de_creditos">
                                <a href="reporte-creditos.php" class="nav-link <?php if ($ruta == 'reporte-creditos.php') echo ' active'; ?>">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                    <p>Creditos</p>
                                </a>
                            </li>
                            <li class="nav-item d-none" id="Reporte_diario_de_cobranza">
                                <a href="reporte-diario-cobranza.php" class="nav-link <?php if ($ruta == 'reporte-diario-cobranza.php') echo ' active'; ?>">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                    <p>Diario de cobranza</p>
                                </a>
                            </li>
                </li>
                    

                </ul>
            </li>
            <!-- <li class="nav-item d-none" id="Configuraciones">
                <a href="configuraciones.php" class="nav-link <?php if ($ruta == 'configuraciones.php') echo ' active'; ?>">
                    <i class="fa-solid fa-gears"></i>
                    <p>Configuraciones</p>
                </a>
            </li> -->

            <li class="nav-item">
                <a class="nav-link" id="cerrarSesion" style="cursor: pointer;" onclick="logout()">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <p>Cerrar sesión</p>
                </a>
            </li>

            </ul>

        </nav>
    </div>
</aside>


