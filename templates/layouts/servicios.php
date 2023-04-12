<?php include 'config/materiales.php'; ?>

<div class="servicios" id="servicios">


    <img src="resources/tanque.png" alt="Tanque tagro" class="servicios__img" data-aos="fade-right">

    <div class="servicios__contenedor">


        <div class="servicios__row">

            <div class="servicios__card" data-aos="fade-right">

                <div class="servicios__card-titulo">

                    INGENIERÍA

                </div>

                <div class="servicios__card-texto">

                    Realización de toda la ingeniería requerida para el proyecto
                    ofrecido, memorias de calculo y planos constructivos de losa y tanque.

                </div>

            </div>

            <div class="servicios__card" data-aos="fade-left">

                <div class="servicios__card-titulo">

                    PREPARACIÓN

                </div>

                <div class="servicios__card-texto">

                    Diseño y construcción de losa de cimentación para soporte del tanque, incluyendo en algunos 
                    casos mecánica de suelo y preparación del terreno.

                </div>


            </div>

        </div>

        <div class="servicios__row">

            <div class="servicios__card" data-aos="fade-right">

                <div class="servicios__card-titulo" >

                    MANUFACTURA

                </div>

                <div class="servicios__card-texto">

                    Suministro de materiales y comienzo de fabricación de partes en taller.

                </div>

            </div>

            <div class="servicios__card" data-aos="fade-left">

                <div class="servicios__card-titulo">

                    CONSTRUCCIÓN

                </div>

                <div class="servicios__card-texto">

                    Ensamble de las partes totales del tanque (techo, cuerpos del tanque fondo, en caso de llevar).

                </div>


            </div>

        </div>

        <div class="servicios__row servicios__row--mt2">

            <div class="servicios__titulo" data-aos="fade-up">
                Ofrecemos una excelente mano de obra <span>calificada y certificada</span>  
                con sobrada experiencia en la elección de tanques.
            </div>

        </div>

    </div>

    <div class="servicios__materiales">

        <div class="servicios__materiales-menu">

            <div class="servicios__materiales-titulo" id="servicio-title">
                 Acero inoxidable
            </div>

            <?php $contador = 0; foreach($materiales['menu'] as $key => $value): ?>

                <div class="servicios__materiales-menu-item" data-title="<?php echo $key ?>" data-item="<?php echo $materiales['menu'][$key]['id']; ?>">
                    <div class="servicios__materiales-menu-numero">
                        <?php $contador++; echo ($contador < 10 ? '0'.$contador : $contador) ?>
                    </div>
                    <div class="servicios__materiales-menu-texto" id="servicio_material">
                        <?php echo $key; ?>
                    </div>
                </div>

            <?php endforeach;?>

        </div>


            <?php foreach($materiales['menu'] as $key => $value):?>

                <div class="servicios__materiales-descripcion" id="<?php echo $materiales['menu'][$key]['id']; ?>" style="<?php echo ($materiales['menu'][$key]['visible'] == 'false' ? 'display:none' : '') ?>">

                    <div class="servicios__materiales-img">

                        <img src="<?php echo $materiales['menu'][$key]['img'] ?>" alt="Tanque" >

                    </div>

                    <div class="servicios__materiales-info">

                        <?php echo ( array_key_exists('texto',$materiales['menu'][$key]) ? $materiales['menu'][$key]['texto'] : '' ) ?>
                
                        <ul  class="servicios__materiales-lista">

                            <?php if(array_key_exists('lista',$materiales['menu'][$key])): ?>

                                <?php foreach($materiales['menu'][$key]['lista'] as $value): ?>

                                    <li><?php echo $value ?></li>

                                <?php endforeach;?>

                            <?php endif;?>

                        </ul>

                        <?php if(array_key_exists('logos',$materiales['menu'][$key])): ?>

                            <div class="servicios__materiales-logos">
                                <?php foreach($materiales['menu'][$key]['logos'] as $value): ?>

                                    <div class="servicios__materiales-logo">
                                        <img src="<?php echo $value ?>" alt="Logo">
                                    </div>

                                <?php endforeach;?>
                            </div>

                        <?php endif;?>


                        <?php if(array_key_exists('fichas_tecnicas',$materiales['menu'][$key])): ?>

                            <div class="servicios__materiales-botones">

                                <a class="servicios__materiales-boton">
                                    Descargar Ficha Técnica
                                </a>
                                <?php foreach($materiales['menu'][$key]['fichas_tecnicas'] as $key => $value): ?>

                                <a class="servicios__materiales-boton servicios__materiales-boton--outline" href="<?php echo $value ?>">
                                    <?php echo $key ?>
                                </a>

                                <?php endforeach;?>

                            </div>

                        <?php endif;?>

                        

                    </div>

                </div>
                    
            <?php  endforeach;?>

    </div>

</div>