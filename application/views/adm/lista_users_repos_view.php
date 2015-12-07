<section id="main" class="column">

    <div class="spacer"></div>

    <article class="module width_full">

        <header><h3>Lista de Usuarios Administradores de Repositorios</h3></header>
        <div class="module_content">
            <div id="tab1" class="tab_content">

                <table class="tablesorter" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="header">
                                Nombre
                            </th>
                            <th class="header">
                                Apellido
                            </th>                            
                            <th>
                                Fecha Inscripción
                            </th>
                            <th>
                                Correo
                            </th>
                            <th>
                                Acciones
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuariosrepos as $key) { ?>
                            <tr>
                                <td width="20%">
                                    <?php echo $key['nombre']; ?>
                                </td>
                                <td width="20%"> 
                                    <?php echo $key['apellido'] ?>
                                </td>                               
                                <td width="15%">
                                    <?php echo $key['fecha_registro'] ?> 
                                </td>
                                <td width="15%">
                                    <?php echo $key['email'] ?> 
                                </td>
                                <td>
                                    <a href="<?php echo base_url()?>index.php/adm_repo/modificar_user_repo/?user=<?php echo base64_encode($key['username'])?>&rol=<?php echo base64_encode($key['rol'])?>" ><button><img src="<?php echo base_url() ?>css/adm/images/icn_edit.png" width="16px"  height="16px"/></button></a>
                                </td>

                            </tr>
                        <?php } ?>


                    </tbody>

                </table>
            </div >


        </div>



        </div>


    </article>
</section>