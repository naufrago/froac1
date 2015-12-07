<script type="text/javascript" charset="utf-8">
    $(function() {
        $.fn.raty.defaults.path = '<?php echo base_url() ?>lib/raty/lib/img';

        $('.star').raty({
            click: function(score, evt) {
                var datos = $(this).attr('id') + "+" + score;
                $.post("<?php echo base_url() ?>index.php/usuario/calificar", {datos: datos}, function(respuesta) {

                });
            }, score: function() {
                return $(this).attr('data-score');
            }
        });
        $("#fecha_nac").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "1945:2035"
        });


        $(".info2").hide().
                oTable = $('#lom_table').dataTable({
            "bJQueryUI": true,
            "oLanguage": {
                "sUrl": "<?php echo base_url() ?>/lib/dtables/spanish.txt"
            }
        });
        

    });
</script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('.1_rating').ratingbar({
            showText: false,
            wrapperClass: "com_wrapper",
            innerClass: "com_inner"
        });
        $('.2_rating').ratingbar({
            showText: false,
            wrapperClass: "cos_wrapper",
            innerClass: "cos_inner"
        });
        $('.3_rating').ratingbar({
            showText: false,
            wrapperClass: "coh_wrapper",
            innerClass: "coh_inner"
        });
        $('.4_rating').ratingbar({
            showText: false,
            wrapperClass: "dis_wrapper",
            innerClass: "dis_inner"
        });

    });
</script>
<script>
    $(function() {
        $("input[type=button]")
                .button()
    });
</script> 
<script type="text/javascript">
    function mostrar_div(div) {
        var nodo = "#info2" + div;
        if ($(nodo).is(":visible")) {
            $(nodo).hide();
            return false;
        } else {

            $(".oculto").hide();
            $(nodo).fadeToggle("slow");
            return false;
        }


    }
</script>

<script>
    $(document).ready(function() {
        $(".btn").button();
        $("#dialog-message").hide();
        $("#tabs").tabs({ active: 3 });
        $("#edit_pref_view").hide();
        $("#estilo").hide();
        $("#edit_dat_view").hide();
        $("#cambiar_pref").click(function() {
            $("#pref_view").hide();
            $("#edit_pref_view").show();
        });
       

        $("#c_pref").click(function() {
            $("#pref_view").show();
            $("#edit_pref_view").hide();
        });

        $("#cambiar_dat").click(function() {
            $("#dat_view").hide();
            $("#edit_dat_view").show();
             $( "#dialog-message" ).dialog({
      modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
    });
        });

        $("#c_dat1").click(function() {
            $("#dat_view").show();
            $("#edit_dat_view").hide();
        });
        $("#c_dat2").click(function() {
            $("#dat_view").show();
            $("#estilo").hide();
        });

        $("#edit_usr").click(function() {
            $("#dat_view").hide();
            $("#estilo").show();
        });
        
        $('#proc').click(function() {
            var form_data = $('#form_usr').serializeArray();
            $.post("<?php echo base_url() ?>index.php/usuario/up_test", form_data, function(respuesta) {
               //$("#result").text(respuesta);
                //$('#result_test').text(respuesta);
                $('#dat_view').show();
                $('#estilo').hide();
                location.reload();
                
            });
        });
        
                $('#submitg').click(function() {
            var form_data = $('#form_dat').serializeArray();
            $.post("<?php echo base_url() ?>index.php/usuario/up_usr", form_data, function(respuesta) {
               //$("#result").text(respuesta);
                //$('#result_test').text(respuesta);
                $('#dat_view').show();
                $('#edit_dat_view').hide();
                location.reload();
                
            });
        });




    });
</script>  

<div id="dialog-message" title="Atención">
  <p>
    <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
    Si cambia sus datos personales, su session se cerrara y debera entrar nuevamente.
  </p>
  <p>
      <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
    Si cambia su usuario y contraseña debera abrir su sesion con los nuevos datos.
  </p>
</div>
<h2 class="art-postheader">Bienvenido a su cuenta en FROAC</h2>
<br>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Noticias</a></li>
        <li><a href="#tabs-2">Mis preferencias</a></li>
        <li><a href="#tabs-3">Mis Objetos</a></li>
        <li><a href="#tabs-4">Mi cuenta</a></li>
    </ul>


    <div id="tabs-1">
        <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
    </div>


    <div id="tabs-2">
        <div class="art-postcontent">


            <div id="pref_view">
                <h3>Tus preferencias son:</h3>
                <ul>
                    <?php 
                    $i = 0;
                    $pref = array();
                    foreach ($preferencia as $key) {
                        $pref[$i] = $key->id_preferencia;
                        $i++;
                        ?>
                        <li><?php echo $key->preferencia;
                        ?></li>
                    <?php } ?>
                </ul>
                <input type="button" class="btne" value="Cambiar mis preferencias" id="cambiar_pref">

            </div> 

            <div id="edit_pref_view">
                <form method="POST" enctype="multipart/form-data" action="<?php echo base_url() ?>index.php/usuario/up_preferencia" id="form_pref">
                    <input type="hidden" value="<?php echo $username ?>" name="username">
                    <h3 class="art-postheader">Preferencias</h3>
                    <table border="0">
                        <thead>
                            <tr>
                                <td>Temas:</td>
                                <td>

                                    <?php foreach ($preferencias as $key) { ?>

                                        <input type="checkbox" name="pref[]" value="<?php echo $key->id_preferencia ?>" <?php if (in_array($key->id_preferencia, $pref)) echo 'checked="checked"'; ?> /><?php echo $key->preferencia ?><br />

                                    <?php } ?>
                                    <input type="submit" value="Actualizar" class="btne"><input type="button" value="Cancelar" id="c_pref" class="btne">
                                </td>
                                <td></td>
                            </tr>
                    </table>
                </form>
            </div> 
        </div> 

    </div>


    <div id="tabs-3">



        <table cellpadding="0" cellspacing="0" border="0" class="display" id="lom_table">
            <thead>
                <tr>
                    <th>Objetos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

                <?php
                                
                $i = 0;

                foreach ($lom as $data) {

                    foreach ($data as $row) {
                        ?>

                        <tr class="gradeA">
                            <td>
                                <div class="info">
                                    
                                    <table>
                                        <tr>
                                            <td width="200"><b>Titulo:</b></td><td><a href="<?php echo $row->location ?>" title="Descargar este Objeto" style="text-decoration: none; "><?php if (!empty($row->general_title)) echo $row->general_title ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><b>Ubicación:</b></td><td></td>
                                        </tr>
                                        <tr>
                                            <td><b>Descripción:</b></td><td><?php if (!empty($row->description)) echo $row->description; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Palabras Claves:</b></td>
                                            <td>
                                                <?php
                                                if (!empty($keyword)) {
                                                    foreach ($keyword as $key) {
                                                        foreach ($key as $def) {
                                                            if ($def['idlom'] == $row->idlom)
                                                                echo $def['keyword'] . ', ';
                                                        }
                                                    };
                                                }
                                                ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Formatos:</b></td><td><?php if (!empty($row->format)) echo $row->format; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td><td><input type="button" value="Ver más" id="<?php echo $i ?>mostrar" onclick="mostrar_div(<?php echo $i ?>)" ></td>
                                        </tr>
                                    </table>  
                                </div>
                                <div id="info2<?php echo $i ?>" class="info2">
                                    <table>
                                        <tr>
                                            <td width="200"><b>Nivel de Agregación:</b></td><td><?php echo $row->general_aggregationlevel ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Tamaño:</b></td><td><?php if (!empty($row->technical_size)) echo round(intval($row->technical_size) / 1024) ?> KB</td>
                                        </tr>
                                        <tr>
                                            <td><b>Localización:</b></td><td><b><a href="<?php echo $row->location ?>"><?php if (!empty($row->location)) echo $row->location ?></a></b></td>
                                        </tr>
                                        <tr>
                                            <td><b>Estructura:</b></td>
                                            <td>
                                                <?php
                                                if (!empty($row->general_structure)) {
                                                    switch ($row->general_structure) {
                                                        case "1":
                                                            echo "atómica";
                                                            break;
                                                        case "2":
                                                            echo "colección";
                                                            break;
                                                        case "3":
                                                            echo "en red";
                                                            break;
                                                        case "4":
                                                            echo "jerárquica";
                                                            break;
                                                        case "5":
                                                            echo "lineal";
                                                            break;
                                                        case "0":
                                                            echo "";
                                                            break;
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Idioma:</b></td><td><?php if (!empty($row->language)) echo $row->language; ?></td>
                                        </tr>

                                    </table> 
                                </div>


                            </td>
                            <td><table>
                                    <tr><td> <span>Opciones: <br><a href="<?php if (!empty($row->location)) echo $row->location ?>"><img src="<?php echo base_url() ?>css/froac/images/downloadOAimg.png"></a></span>
                                            <br></td></tr>
                                    <tr><td> <span><?php  if (!empty($username)) { ?>
                                                    Calificar:<br>
                                                                <?php
                                              $score = 0;
                                              if (!empty($cal)){
                                             foreach($cal as $caf){
                                                        if ($row->idlom == $caf->idlom){
                                                           $score =  $caf->calificacion; 
                                        }}
                                                     
                                                        
                                                        } ?>
                                                    <div id="<?php echo $row->idrepository . '+' . $row->idlom . '+' . $username ?>" class="star" data-number="5" data-score="<?php echo $score?>"></div>

                                                <?php } ?></span></td></tr>
                                    <tr><td>
                                            <table>
                                                <tr>
                                                    <td class="1_rating">45</td>
                                                </tr>
                                                <tr>
                                                    <td class="2_rating">29</td>
                                                </tr>
                                                <tr>
                                                    <td class="3_rating">100</td>
                                                </tr>
                                                <tr>
                                                    <td class="4_rating">98</td>
                                                </tr>
                                            </table>

                                        </td></tr>
                                </table>

                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>

        <div style="float: left; margin-right: 20px; overflow: hidden;">

        </div>

    </div>


    <div id="tabs-4">
        <div id="dat_view">
            <h3>Tus datos:</h3><br>
            <?php
            foreach ($info as $key) {
                
            }
            ?>
            <table>
                <tr>
                    <td><b>Nombre:</b></td>
                    <td><?php echo $key->nombre . ' ' . $key->apellido; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>E-mail</b></td>
                    <td><?php echo $key->email; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Fecha de Nacimiento</b></td>
                    <td><?php echo $key->fecha_nacimiento; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Sexo</b></td>
                    <td><?php
                        if ($key->sexo == 'h')
                            echo 'Hombre';
                        elseif ($key->sexo == 'm') {
                            echo 'Mujer';
                        } else {
                            echo 'Otro';
                        }
                        ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Nombre de usuario</b></td>
                    <td><?php echo $username?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Estilo de aprendizaje</b></td>
                    <td><span id="result_test"><?php echo $key->estilo_aprendizaje; ?>:</span>
                        <span id="result_test"><?php echo $key->descripcion_estilo; ?></span>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td><b></b></td>
                    <td></td>
                    <td></td>
                </tr>
            </table><br>
            <input type="button" id="cambiar_dat" value="Cambiar mis datos" class="btne"><input type="button" id="edit_usr" value="Realizar Test de Estilo de aprendizaje" class="btne">
        </div>

        <div id="estilo"><input type="button" value="Cancelar" id="c_dat2" class="btn">
            <h1>Test de Estilos de Aprendizaje</h1>
            <form action="<?php echo base_url() ?>index.php/usuario/" name="form_est" id="form_est" method="POST" enctype="multipart/form-data">
                <table class="table1" width="100%" border="0" cellspacing="1" cellpadding="0" align="center"><tr><td>
                            <input type="hidden" value="<?php echo $username?>" name="iduser">
                            <table class="table2" width="100%" border="0" cellspacing="5" cellpadding="0" align="center">
                                <tr> 
                                    <td class="boxtitle" align="center">¿Cómo aprendo mejor?</td>                    
                                </tr>
                                <tr> 
                                    <td align="justify">
                                        Este cuestionario tiene como propósito saber algo acerca de sus preferencias sobre cómo trabaja con
                                        información. Usted tendrá un estilo de aprendizaje preferido y una parte de ese Estilo de Aprendizaje es
                                        su preferencia para capturar, procesar y entregar ideas e información.
                                        Escoja las respuestas que mejor explican su preferencia. Seleccione mas de una
                                        respuesta si una respuesta simple no encaja con su percepción (Preguntas de la 1 a la 13). 
                                        De la pregunta 14 a la pregunta 24 seleccione una sola respuesta. <br>
                                        Deje en blanco toda pregunta que no se aplique.
                                    </td>                    
                                </tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        1. Usted está por darle instrucciones a una persona que está junto a usted, esa persona es de fuera, no
                                        conoce la ciudad, esta alojada en un hotel y quedan en encontrarse en otro lugar más tarde. Usted que
                                        haría?
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="1" VALUE="V"> Dibujo un mapa en un papel.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="2" VALUE="A"> Le digo cómo llegar.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="3" VALUE="R"> Le escribo las instrucciones (sin dibujar un mapa).</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="4" VALUE="K"> La busco y recojo en el hotel.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        2. Usted no está seguro como se deletrea la palabra tracendente o trascendente. Que haría usted.
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="5" VALUE="R"> Busco la palabra en un diccionario.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="6" VALUE="V"> Veo la palabra en mi mente y escojo según como la veo</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="7" VALUE="A"> La repito en mi mente.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="8" VALUE="K"> Escribo ambas versiones en un papel y escojo una.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        3. Usted acaba de recibir una copia de un itinerario para un viaje mundial. Esto le interesa a un/a amigo/o.
                                        Usted que haría?
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="9" VALUE="A"> Hablarle por teléfono inmediatamente y contarle del viaje.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="10" VALUE="R"> Enviarle una copia del itinerario impreso.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="11" VALUE="V"> Mostrarle un mapa del mundo.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="12" VALUE="K"> Compartir que planea hacer en cada lugar que visite.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        4. Usted esta por cocinar algo muy especial para su familia. Usted.
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="13" VALUE="K"> Cocina algo familiar que no necesite receta o instrucciones</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="14" VALUE="V"> Da una vista a través de un recetario por ideas de las fotos.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="15" VALUE="R"> Busca un libro de recetas especifico donde hay una buena receta.</td></tr>	                                    
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        5. Un grupo de turistas le han sido asignados para que usted les explique del Area Nacional Protegida. Usted,
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="16" VALUE="K"> Organiza un viaje por el lugar.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="17" VALUE="V"> Les muestra fotos y transparencias</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="18" VALUE="R"> Les da un folleto o libro sobre las Areas Nacionales Protegidas.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="19" VALUE="A"> Les da una platica sobre las Areas Nacionales Protegidas.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        6. Usted está por comprarse un nuevo estéreo. Que otro factor, además del precio, influirá su decisión
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="20" VALUE="A"> El vendedor le dice lo que usted quiere saber.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="21" VALUE="R"> Leyendo los detalles sobre el estéreo.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="22" VALUE="K"> Jugando con los controles y escuchándolo.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="23" VALUE="V"> Luce muy bueno y a la moda (padre, cool, chido).</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        7. Recuerde un momento en su vida en que usted aprendió a hacer algo como a jugar un nuevo juego de
                                        cartas. Trate de evitar escoger una destreza física, como andar en bicicleta. Cómo aprendió usted mejor?
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="24" VALUE="V"> Pistas visuales—fotos, diagramas, cuadros...</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="25" VALUE="R"> Instrucciones escritas</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="26" VALUE="A"> Escuchando a alguien que se lo explicaba.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="27" VALUE="K"> Haciéndolo o probándolo.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        8. Si usted tiene un problema en un ojo, usted prefiere que el doctor
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="28" VALUE="A"> Le diga que anda mal.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="29" VALUE="V"> Le muestre un diagrama de que está mal.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="30" VALUE="K"> Use un modelo para enseñarle qué está mal.</td></tr>	                                    
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        9. Usted está apunto de aprender un nuevo programa en la computadora. Usted,
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="31" VALUE="K"> Se sienta frente al teclado y empieza a experimentar con el programa.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="32" VALUE="R"> Lee el manual que viene con el programa.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="33" VALUE="A"> Telefonea a un amigo y le hace preguntas sobre el programa.</td></tr>	                                    
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        10. Usted va en su coche, a otra ciudad, en donde tiene amigos que quiere visitar. Usted quisiera que ellos:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="34" VALUE="V"> Le dibujen un mapa en un papel.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="35" VALUE="A"> Le den las instrucciones para llegar.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="36" VALUE="R"> Escriban las instrucciones (sin el mapa)</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="37" VALUE="K"> Lo esperen a usted en la gasolinera de la entrada a la ciudad.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        11. Aparte del precio, que influirá más su decisión de compra de un libro de texto particular?
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="38" VALUE="K"> Usted ha usado una copia antes.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="39" VALUE="A"> Un amigo le ha platicado acerca del libro.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="40" VALUE="R"> Una lectura rápida de algunas partes del libro.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="41" VALUE="V"> El diseño de la pasta del libro es atractiva.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        12. Una nueva película ha llegado a los cines de la ciudad. Que influirá mas en la decisión de ir al cine o
                                        no—asumiendo que tiene el dinero para los boletos---
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="42" VALUE="A"> Usted oyó en el radio acerca de la película</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="43" VALUE="R"> Usted Leyó una reseña de la película.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="44" VALUE="V"> Usted vió una reseña en la televisión o en el cine.</td></tr>	                                    
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        13. Usted prefiere que un profesor/maestro o conferencista use:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="45" VALUE="R"> Un libro de texto, copias, lecturas.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="46" VALUE="V"> Un diagrama de flujo, cuadros, gráficos, dispositivas.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="47" VALUE="K"> Sesiones prácticas, laboratorio, visitas, viajes de campo.</td></tr>	                
                                <tr><td ><INPUT TYPE=CHECKBOX NAME="48" VALUE="A"> Preguntas y respuestas, charlas, grupos de discusión u oradores invitados</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        14. Tengo tendencia a:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=RADIO NAME="49" VALUE="S"> Entender los detalles de un tema pero no ver claramente su estructura completa.</td></tr>	                
                                <tr><td ><INPUT TYPE=RADIO NAME="49" VALUE="G"> Entender la estructura completa pero no ver claramente los detalles.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        15. Una vez que entiendo:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=RADIO NAME="50" VALUE="G"> Todas las partes, entiendo el total.</td></tr>	                
                                <tr><td ><INPUT TYPE=RADIO NAME="50" VALUE="S"> El total de algo, entiendo como encajan sus partes.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        16. Cuando resuelvo problemas de matemáticas:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=RADIO NAME="51" VALUE="S"> Generalmente trabajo sobre las soluciones con un paso a la vez.</td></tr>	                
                                <tr><td ><INPUT TYPE=RADIO NAME="51" VALUE="G"> Frecuentemente sé cuales son las soluciones, pero luego tengo dificultad  para imaginarme los pasos para llegar a ellas.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        17. Cuando estoy analizando un cuento o una novela:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=RADIO NAME="52" VALUE="G"> Pienso en los incidentes y trato de acomodarlos para configurar los temas.</td></tr>	                
                                <tr><td ><INPUT TYPE=RADIO NAME="52" VALUE="S"> Me doy cuenta de cuales son los temas cuando termino de leer y luego tengo que regresar y encontrar los incidentes que los demuestran.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        18. Es más importante para mí que un profesor:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=RADIO NAME="53" VALUE="S"> Exponga el material en pasos secuenciales claros.</td></tr>	                
                                <tr><td ><INPUT TYPE=RADIO NAME="53" VALUE="G"> Me dé un panorama general y relacione el material con otros temas.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        19. Aprendo:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=RADIO NAME="54" VALUE="S"> A un paso constante. Si estudio con ahínco consigo lo que deseo.</td></tr>	                
                                <tr><td ><INPUT TYPE=RADIO NAME="54" VALUE="G"> En inicios y pausas. Me llego a confundir y súbitamente lo entiendo.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        20. Cuando me enfrento a un cuerpo de información:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=RADIO NAME="55" VALUE="S"> Me concentro en los detalles y pierdo de vista el total de la misma.</td></tr>	                
                                <tr><td ><INPUT TYPE=RADIO NAME="55" VALUE="G"> Trato de entender el todo antes de ir a los detalles.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        21. Cuando escribo un trabajo, es más probable que:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=RADIO NAME="56" VALUE="G">  Lo haga (piense o escriba) desde el principio y avance.</td></tr>	                
                                <tr><td ><INPUT TYPE=RADIO NAME="56" VALUE="S">  Lo haga (piense o escriba) en diferentes partes y luego las ordene.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        22. Cuando estoy aprendiendo un tema, prefiero:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=RADIO NAME="57" VALUE="S"> Mantenerme concentrado en ese tema, aprendiendo lo más que pueda de él.</td></tr>	                
                                <tr><td ><INPUT TYPE=RADIO NAME="57" VALUE="G"> Hacer conexiones entre ese tema y temas relacionados.</td></tr>	                
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        23. Algunos profesores inician sus clases haciendo un bosquejo de lo que enseñarán. Esos bosquejos son:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=RADIO NAME="58" VALUE="S"> Algo útiles para mí.</td></tr>	                
                                <tr><td ><INPUT TYPE=RADIO NAME="58" VALUE="G"> Muy útiles para mí.</td></tr>	                
                                <tr>
                                <tr>
                                <tr><td>&nbsp;</td></tr>	                
                                <tr> 
                                    <td class="storytitle">
                                        24. Cuando resuelvo problemas en grupo, es más probable que yo:
                                    </td>
                                </tr>	       
                                <tr><td ><INPUT TYPE=RADIO NAME="59" VALUE="S"> Piense en los pasos para la solución de los problemas.</td></tr>	                
                                <tr><td ><INPUT TYPE=RADIO NAME="59" VALUE="G"> Piense en las posibles consecuencias o aplicaciones de la solución en un amplio rango de campos.</td></tr>	                
                                <tr>

                                <tr><td>&nbsp;</td></tr>	                                  	                                     
                                <tr>                 


                                    <td class="cuadroOscuro" colspan="2" align="center">
                                        <input type="hidden" name="op" value="guardar_vark">
                                        <input type="hidden" name="mod" value="mod_vark">

                                        <input type="button" value="Enviar" name="guardar" id="proc">                                                   
                                    </td>
                                </tr>	
                            </table>
                        </td></tr></table>            </form>

        </div>

        <div id="edit_dat_view">
            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url() ?>index.php/usuario/up_usr" id="form_dat">
                <h3 class="art-postheader">Datos personales</h3>
                <table class="table">
                    <tr>
                        <td>
                            <table border="0">

                                <tr>
                                    <td>Nombres:</td>
                                    <td><input type="text" name="nombre" id="nombre" value="<?php echo $key->nombre?>" /></td>
                                </tr>
                                <tr>
                                    <td>Apellidos:</td>
                                    <td><input type="text" name="apellido" value="<?php echo $key->apellido; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Fecha de Nacimiento:</td>
                                    <td><input type="text" name="fecha_nac" id="fecha_nac" value="<?php echo $key->fecha_nacimiento; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>E-mail:</td>
                                    <td><input type="text" name="email" value="<?php echo $key->email; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Sexo</td>
                                    <td><select name="sexo"><?php
                        if ($key->sexo == 'h')
                            echo "<option value='h'>Hombre</option>";
                        elseif ($key->sexo == 'm') {
                            echo "<option value='m'>Mujer</option>";
                        } else {
                            echo "<option value='o'>Otro</option>";
                        }
                        ?>
                                            <option value='h'>Hombre</option>
                                            <option value='m'>Mujer</option>
                                            <option value='o'>Otro</option>
                                        </select></td>
                                </tr>
          
                                
                            </table>



                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>  

                        </td>

                    </tr>
                </table>
                <input type="hidden" name="result_test" id="result_test" value="0">
                <h3 class="art-postheader" id="result"></h3>
                <input type="button" value="Actualizar información" id="submitg" class="btn">
                <input type="button" value="Cancelar" id="c_dat1" class="btn">
            </form>
        </div>

    </div>
</div>
<script type="text/javascript">
function mostrar_div(div) {
    var nodo = "#info2" + div;
    var btn = "#" + div + "mostrar";
    if ($(nodo).is(":visible")) {
        $(nodo).hide();
        $(btn).val('Ver más');
        return false;
    } else {

        $(".oculto").hide();
        $(nodo).fadeToggle("slow");
        $(btn).val('Ver menos');
        return false;
    }


}
</script>