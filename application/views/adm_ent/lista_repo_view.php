<script type="text/javascript">
    $(document).ready(function() {


        $("#submitg, #boton, #cancelar, #proc").button();
        $("#fechainicio").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"

        });
        $("#fechafin").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"

        });
//        if($('#tiporepo').text()=="roap"){

//        }
    });

</script>

<section id="main" class="column">

    <div class="spacer"></div>

    <article class="module width_full">

        <header><h3>Lista de Repositorios</h3></header>
        <div class="module_content">
            <div id="tab1" class="tab_content">

                <table class="tablesorter" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="header">
                                Nombre
                            </th>

                            <th class="header">
                                Tipo
                            </th>
                            <th>
                                Periodo
                            </th>
                            <th class="header">
                                Cant. OAs
                            </th>
                            <th class="header">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($repos as $key) {
                            $i+=1
                            ?>

                            <tr>
                                <td width="10%"> 
                                    <?php echo $key['name'] ?>
                                </td>
                                <td width="10%">
                                    <a id="tiporepo"><?php echo $key['typerepository'] ?></a>
                                </td>
                                <td width="10%">
                                    <?php echo $key['frequency'] ?> 
                                </td>
                                <td width="10%">
                                    <?php echo $key['countoas'] ?> 
                                </td >
                                <td width="55%">
                                    <table>
                                        <tr>
                                        <form autocomplete="off" action="<?php echo base_url() ?>index.php/adm_repo/actualizar_oas/" method="post" enctype="multipart/form-data">
                                            <input type="hidden" id="idrepository" name="idrepository" value="<?php echo $key['idrepository']; ?>" />
                                            <input type="hidden" id="lastupdate" name="lastupdate" value="<?php echo $key['lastupdate']; ?>" />
                                            <input type="hidden" id="cadenaoai" name="cadenaoai" value="<?php echo $key['host']; ?>" />
                                            <input type="hidden" id="metadata" name="metadata" value="<?php echo $key['metadata_inf']; ?>" />  
               <?php if($key['typerepository']!='roap'){?>
                                            <td width="30%">
                                                
                                                <div  id="actualizaroa<?php echo $i; ?>">
                                                    <input type="radio" id="actualizar<?php echo $i; ?>" name="actualizar" value="1"/>Todo<br/>
                                                    <input type="radio" id="actualizar<?php echo $i; ?>" name="actualizar" value="2" checked="TRUE"/>Desde <?php echo $key['lastupdate'] ?> <br/>
                                                    <input type="radio" id="actualizar<?php echo $i; ?>" name="actualizar" value="3"/>Rango de Fechas:<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    Inicio:<input class="inputext1" id="fechainicio"type="text"  value="" name="fechainicio" /><br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    Fin:&nbsp;&nbsp;&nbsp;&nbsp;<input class="inputext1" id="fechafin" type="text" value="" name="fechafin" />


                                            </td>

                                            <td width="10%"> 
                                                <button id="refreshbu" width="16px"  height="16px"  type="submit"><img  src="<?php echo base_url() ?>css/adm/images/refresh.jpg"/></button>

                                            </td> 

                                            </div>
                                                <?php }
                                                else{
                                                
                                                }
?>
                                                
                                        </form> 
                                        <td width="10%">                                                              
                                            <form autocomplete="off"  action="<?php echo base_url() ?>index.php/adm_repo/modificar_repo/" method="post" >
                                                <input type="hidden" id="idrepository" name="idrepository" value="<?php echo $key['idrepository']; ?>" />
                                                <button type="submit"><img src="<?php echo base_url() ?>css/adm/images/icn_edit.png" width="16px"  height="16px"/></button>	
                                            </form>
                                        </td>
                                        <td width="10%">                                                              

                                        </td>
                            </tr>   
                    </table>
                    </td>
                    </tr>   


                    <?php
                }
                ?>
                </tbody>

                </table>
            </div>


        </div>



        </div>
        <footer>

        </footer>

    </article>
</section>

