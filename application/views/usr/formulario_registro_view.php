<script type="text/javascript">

    $(document).ready(function() {

        $("#img_ok").hide();
        $("#img_not").hide();
        $("#submitg, #boton, #cancelar, #proc").button();
        $("#fecha_nac").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "1945:2035"
        });
        $(".submitg").click(function() {
            $("#form").validate({
                rules: {
                    nombre: {
                        required: true,
                        minlength: 3
                    },
                    apellido: {
                        required: true,
                        minlength: 3
                    },
                    fecha_nac: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    sexo: {
                        required: true
                    },
                    lang: {
                        required: true
                    },
                    username: {
                        required: true,
                        minlength: 4
                    },
                    passwd: {
                        required: true,
                        minlength: 6
                    },
                    passwd1: {
                        equalTo: "#passwd"
                    }
                },
                messages: {
                    nombre: {
                        required: "<span style=color:red;>Escribe tu Nombre </span>",
                        minlength: "Tu Nombre con minimo 3 letras."
                    },
                    apellido: {
                        required: "<span style=color:red;>Escribe tu Apellido</span>",
                        minlength: "Tu Nombre con minimo 3 letras"
                    },
                    fecha_nac: {
                        required: "<span style=color:red;>Escribe tu Fecha de Nacimiento </span>"
                    },
                    sexo: {
                        required: "<span style=color:red;>Elige tu Sexo </span>"
                    },
                    lang: {
                        required: "<span style=color:red;>Escribe tu Idioma</span>",
                        minlength: "Mail erróneo",
                        error: "Mail erróneo",
                    },
                    username: {
                        required: "<span style=color:red;>Escribe tu Nombre de usuario</span>",
                        minlength: "Tu nombre de ususario con minimo 4 letras"
                    },
                    passwd: {
                        required: "<span style=color:red;>Escribe tu password</span>",
                        minlength: "Tu password con minimo 6 caracteres "
                    },
                    passwd1: {
                        equalTo: "<span style=color:red;>Las contraseñas no coinciden</span>"
                    }
                }
            });


        });


        $('#proc').click(function() {
            var form_data = $('#form_usr').serializeArray();
            $.post("<?php echo base_url() ?>index.php/usuario/test_result", form_data, function(respuesta) {
                // $("#result").text(respuesta);
                $('#result_test').val(respuesta);
                $('#form').show();
                $('#test').hide();
                $('#submitg').show();

                switch ($('#result_test').val()) {
                    case '1':
                        $("#result").text('Su estilo de aprendizaje es: Auditivo-Global ');
                        break;
                    case '2':
                        $("#result").text('Su estilo de aprendizaje es: Auditivo-Secuencial ');
                        break;
                    case '3':
                        $("#result").text('Su estilo de aprendizaje es: Kinestesico-Global ');
                        break;
                    case '4':
                        $("#result").text('Su estilo de aprendizaje es: Kinestesico-Secuencial ');
                        break;
                    case '5':
                        $("#result").text('Su estilo de aprendizaje es: Lector-Global ');
                        break;
                    case '6':
                        $("#result").text('Su estilo de aprendizaje es: Lector-Secuencial ');
                        break;
                    case '7':
                        $("#result").text('Su estilo de aprendizaje es: Visual-Global ');
                        break
                    case '8':
                        $("#result").text('Su estilo de aprendizaje es: Visual-Secuencial ');
                        break

                }

            });
        });
        $('#boton').click(function() {
            $('#test').show();
            $('#form').hide();
            $('#submitg').hide();
        });
        $('#cancelar').click(function() {
            $('#test').hide();
            $('#form').show();
            $('#submitg').show();
        });

        $('#username').blur(function() {
             $.get("<?php echo base_url() ?>index.php/usuario/checkusr/"+$("#username").val(), function(respuesta) {
                  $('#rta').val(respuesta);
        
            if (respuesta == 1){
                $('#img_not').show();
                $('#img_ok').hide();
            } else {
                $('#img_ok').show();
                $('#img_not').hide();
            }
        
            });
           
        });

    });

</script>
<input type="hidden" id="rta">
<div class="art-post-inner art-article">
    <h2 class="art-postheader">Registro de usuario</h2>
    <div class="art-postmetadataheader">

    </div>
    <div class="art-postcontent">
        <form autocomplete="off" method="POST" enctype="multipart/form-data" action="<?php echo base_url() ?>index.php/usuario/guardar" id="form">
            <h3 class="art-postheader">Datos personales</h3>
            <table class="table">
                <tr>
                    <td>
                        <table border="0">

                            <tr>
                                <td>Tipo de Usuario</td>
                                <td><select name="tipoU" id="tipoU">
                                        <option value="3">Estudiante</option>
                                        <option value="4">Profesor</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td>Nombres:</td>
                                <td><input type="text" name="nombre" id="nombre" value="" /></td>
                            </tr>
                            <tr>
                                <td>Apellidos:</td>
                                <td><input type="text" name="apellido" value="" /></td>
                            </tr>
                            <tr>
                                <td>Fecha de Nacimiento:</td>
                                <td><input type="text" name="fecha_nac" id="fecha_nac" value="" /></td>
                            </tr>
                            <tr>
                                <td>E-mail:</td>
                                <td><input type="text" name="email" value="" /></td>
                            </tr>
                            <tr>
                                <td>Sexo</td>
                                <td><select name="sexo">
                                        <option value="h">Hombre</option>
                                        <option value="m">Mujer</option>
                                        <option value="o">Otro</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td>Idioma: </td>
                                <td>
                                    <select name="lang">
                                        <option value="es">Español</option>
                                        <option value="ca">Catalán</option>
                                        <option value="pt">Portugues</option>
                                        <option value="en">Ingles</option>
                                        <option value="fr">Frances</option>
                                        <option value="de">Aleman</option>
                                        <option value="it">Italiano</option>
                                        <option value="o">Otro</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Usuario:</td>
                                <td><input type="text" name="username" id="username" value="" />
                                    <span id="img_ok"style=color:red;><img  src="<?php echo base_url() ?>css/img/ok.png" style="border: #ffffff;">Usuario valido</span>
                                    <span id="img_not" style=color:red;><img  src="<?php echo base_url() ?>css/img/not.png" style="border: #ffffff;">Usuario no valido</span>

                                </td>
                            </tr>
                            <tr>
                                <td>Contraseña</td>
                                <td>Ingrese contraseña<br><input type="password" name="passwd1" autocomplete="off" value="" /><br>Repita contraseña<br><input type="password" autocomplete="off" name="passwd" id="passwd" value="" /></td>
                            </tr>
                            <tr>
                                <td><h3 class="art-postheader">Preferencias</h3></td>
                                <td>                                        <?php foreach ($preferencias as $key) { ?>
                                    <input type="checkbox" name="pref[]" value="<?php echo $key->id_preferencia ?>" /><?php echo $key->preferencia ?><br />

                                    <?php } ?></td>
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
            </table><h3 class="art-postheader">Estilo de aprendizaje</h3>
            <p>Para conocer su estilo de aprendizaje puede realizar el test de estilos ahora mismo,
                o lo puede hacer luego</p>
            <input type="button" id="boton" value="Realizar Test">
            <input type="hidden" name="result_test" id="result_test" value="0">
            <h3 class="art-postheader" id="result"></h3>
            <input type="submit" value="Guardar información" id="submitg" class="submitg">

        </form>
        <div id="test" style="display: none;">
            <h1>Test de Estilos de Aprendizaje</h1>
            <form action="<?php echo base_url() ?>index.php/test_estilo_aprendizaje/clasificaresp/" name="form_usr" method="POST" enctype="multipart/form-data">
                <table class="table1" width="100%" border="0" cellspacing="1" cellpadding="0" align="center"><tr><td>
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
                        </td></tr></table>


            </form>
        </div>
    </div>
    <div class="cleared"></div>
</div>