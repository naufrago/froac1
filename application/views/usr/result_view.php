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



        $(".info2").hide().
                oTable = $('#lom_table').dataTable({
            "bJQueryUI": true,
            "bSort": false,
            "oLanguage": {
                "sUrl": "<?php echo base_url() ?>/lib/dtables/spanish.txt"
            }
        });

    });

</script>
<script src="<?php echo base_url() ?>css/froac/jquery.rateit.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>css/froac/rateit.css" rel="stylesheet" type="text/css">

<table cellpadding="0" cellspacing="0" border="0" class="display" id="lom_table">
    <thead>
        <tr>
            <th>Objetos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>

        <?php
//print_r($keyword);
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
                                                    if ($def['idlom'] == $row->idlom && $def['idrepository'] == $row->idrepository)
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
                            <tr>
                                <td> <span>Opciones: <br><a href="<?php if (!empty($row->location)) echo $row->location ?>"><img src="<?php echo base_url() ?>css/froac/images/downloadOAimg.png"></a></span>
                                    <img src="<?php echo base_url() ?>css/froac/images/rate.jpg" style="width: 16px;height: 16px;" onclick="calificaroa(<?php echo $row->idlom ?>,<?php echo $row->idrepository ?>)"/>
                                    <br>
                                </td>
                            </tr>
                            <tr><td> <span><?php if (!empty($username)) { ?>
                                            Calificar:<br>
                                            <?php
                                            $score = 0;
                                            if (!empty($cal)) {
                                                foreach ($cal as $caf) {
                                                    if ($row->idlom == $caf->idlom) {
                                                        $score = $caf->calificacion;
                                                    }
                                                }
                                            }
                                            ?>
                                            <div id="<?php echo $row->idrepository . '+' . $row->idlom . '+' . $username ?>" class="star" data-number="5" data-score="<?php echo $score ?>"></div>

                                        <?php } ?></span></td></tr>
                            <tr><td>
                                    <table>
                                        <tr>
                                            <td class="1_rating">100</td>
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
<div id="evaluacionoas" title="Evaluación OA" style="display:none;">
    <br>
    <div >
        <label>1. En qué nivel el OA lo motivó a seguir consultando sobre el tema</label>
        <div class="rateit" id="ratepregunta1">
        </div>
    </div>
    <br>
    <div >
        <label>2. En qué nivel el contenido encontrado le permitió aprender sobre el tema</label>
        <div class="rateit" id="ratepregunta2">
        </div>
    </div>
    <br>
    <div >
        <label>3. En qué nivel el OA le parece agradable</label>
        <div class="rateit" id="ratepregunta3">
        </div>
    </div>
    <br>
    <div >
        <label>4. Pudo acceder al contenido del OA (0=No 5=Si)</label>
        <div class="rateit" id="ratepregunta4">
        </div>
    </div>
    <br>
    <div >
        <label>5. Califique la facilidad a la hora de interactuar con el OA</label>
        <div class="rateit" id="ratepregunta5">
        </div>
    </div>
    <br>
    <div >
        <label>6. En qué grado los metadatos describen el contenido encontrado</label>
        <div class="rateit" id="ratepregunta6">
        </div>
    </div>
    <br>
    <div >
        <label>7. En qué nivel el este OA fue importante y estaba relacionado con lo que esperaba encontrar</label>
        <div class="rateit" id="ratepregunta7">
        </div>
    </div>

    <script>
        $(function() {
            $("#evaexperto").tabs();
        });
    </script>

    <div id="evaexperto" style="display:none" title="Evaluación Experto">
        <ul>
            <li><a href="#dimeducativa">Dimensión Educativa</a></li>
            <li><a href="#dimcontenido">Dimensión de Contenido</a></li>
            <li><a href="#dimestetica">Dimensión Estetica</a></li>
            <li><a href="#dimfuncional">Dimensión Funcional</a></li>
            <li><a href="#dimmetadatos">Dimensión Metadatos</a></li>

        </ul>
        <div id="dimeducativa">
            <label>Para esta dimensión indique su nivel de experticia:</label>
            <div class="rateit" id="ratedimedu">
            </div>
            <br>
            <br>            
            <label>1. En qué nivel se logran identificar los objetivos educativos que pretende cubrir el OA.</label>
            <div class="rateit" id="ratepreguntaex1">
            </div>
            <br>
            <br>
            <label>2. En qué nivel la estructura y contenido del OA apoyan el aprendizaje del tema.</label>
            <div class="rateit" id="ratepreguntaex2">
            </div>
        </div>

        <div id="dimcontenido">
            <label>Para esta dimensión indique su nivel de experticia:</label>
            <div class="rateit" id="ratedimcont">
            </div>
            <br>
            <br>
            <label>3. En qué nivel el contenido presentado es claro, veraz, coherente, no discriminatorio, respeta derechos de autor, y se presenta sin sesgos u omisiones.</label>
            <div class="rateit" id="ratepreguntaex3">
            </div>
            <br>
            <br>
            <label>4. En qué nivel el OA se encuentra libre de errores ortográficos y gramaticales.</label>
            <div class="rateit" id="ratepreguntaex4">
            </div>
        </div>
        <div id="dimestetica">
            <label>Para esta dimensión indique su nivel de experticia:</label>
            <div class="rateit" id="ratedimeste">
            </div>
            <br>
            <br>
            <label>5. La distribución y tamaño de elementos, la jerarquía visual, el diseño tipográfico y contraste de los colores es adecuado.</label>
            <div class="rateit" id="ratepreguntaex5">
            </div>
            <br>
            <br>
            <label>6. La elección de los textos, imágenes, sonidos u otros elementos multimedia aportan a los objetivos de aprendizaje.</label>
            <div class="rateit" id="ratepreguntaex6">
            </div>
        </div>
        <div id="dimfuncional">
            <label>Para esta dimensión indique su nivel de experticia:</label>
            <div class="rateit" id="ratedimfunc">
            </div>
            <br>
            <br>
            <label>7. Cuál es la posibilidad que ofrece el OA para que sea utilizado en varios escenarios educativos</label>
            <div class="rateit" id="ratepreguntaex7">
            </div>
            <br>
            <br>
            <label>8. En qué grado el OA es auto contenido y no presenta dependencias</label>
            <div class="rateit" id="ratepreguntaex8">
            </div>
            <br>
            <br>
            <label>9. Cuál es el nivel de claridad respecto a lo que debe hacer el usuario para utilizar el OA</label>
            <div class="rateit" id="ratepreguntaex9">
            </div>
            <br>
            <br>
            <label>10. Califique la relación entre la necesidad y la ayuda provista</label>
            <div class="rateit" id="ratepreguntaex10">
            </div>
            <br>
            <br>
            <label>11. En qué nivel no se requiere de software o dispositivos adicionales al momento de acceder al OA</label>
            <div class="rateit" id="ratepreguntaex11">
            </div>
            <br>
            <br>
            <label>12. En qué medida el recurso funciona correctamente y es fácil para el usuario visualizarlo desde diferentes plataformas</label>
            <div class="rateit" id="ratepreguntaex12">
            </div>
        </div>
        <div id="dimmetadatos">
            <label>Para esta dimensión indique su nivel de experticia:</label>
            <div class="rateit" id="ratedimmeta">
            </div>
            <br>
            <br>
            <label>13. Qué tanto los metadatos que tiene el OA lo describen completamente</label>
            <div class="rateit" id="ratepreguntaex13">
            </div>
            <br>
            <br>
            <label>14. En qué nivel los metadatos describen realmente el contenido encontrado</label>
            <div class="rateit" id="ratepreguntaex14">
            </div>
        </div>

    </div>


</div>
<div id="prueba"></div>
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

    function calificaroa(idlom, idrepositori) {

        var rol = <?php echo $rol?>;
        if (rol.toString() == '7') {
            $("#ratedimedu").rateit('value', '1');
            $("#ratedimcont").rateit('value', '1');
            $("#ratedimeste").rateit('value', '1');
            $("#ratedimfunc").rateit('value', '1');
            $("#ratedimmeta").rateit('value', '1');
            $("#ratepreguntaex1").rateit('reset');
            $("#ratepreguntaex2").rateit('reset');
            $("#ratepreguntaex3").rateit('reset');
            $("#ratepreguntaex4").rateit('reset');
            $("#ratepreguntaex5").rateit('reset');
            $("#ratepreguntaex6").rateit('reset');
            $("#ratepreguntaex7").rateit('reset');
            $("#ratepreguntaex8").rateit('reset');
            $("#ratepreguntaex9").rateit('reset');
            $("#ratepreguntaex10").rateit('reset');
            $("#ratepreguntaex11").rateit('reset');
            $("#ratepreguntaex12").rateit('reset');
            $("#ratepreguntaex13").rateit('reset');
            $("#ratepreguntaex14").rateit('reset');
            $("#evaexperto").dialog({
                autoOpen: true,
                show: {
                    effect: "blind",
                    duration: 500
                },
                hide: {
                    effect: "explode",
                    duration: 500
                },
                width: 780,
                height: 500,
                buttons:
                        {
                            "Enviar Calificación": function() {
                                alert($("#ratepreguntaex1").rateit('value'));
                                $.ajax({
                                    url: "<?php echo base_url() ?>index.php/init_user/evaluation_expert/",
                                    data: {
                                        preguntaex1: $("#ratepreguntaex1").rateit('value'),
                                        preguntaex2: $("#ratepreguntaex2").rateit('value'),
                                        preguntaex3: $("#ratepreguntaex3").rateit('value'),
                                        preguntaex4: $("#ratepreguntaex4").rateit('value'),
                                        preguntaex5: $("#ratepreguntaex5").rateit('value'),
                                        preguntaex6: $("#ratepreguntaex6").rateit('value'),
                                        preguntaex7: $("#ratepreguntaex7").rateit('value'),
                                        preguntaex8: $("#ratepreguntaex8").rateit('value'),
                                        preguntaex9: $("#ratepreguntaex9").rateit('value'),
                                        preguntaex10: $("#ratepreguntaex10").rateit('value'),
                                        preguntaex11: $("#ratepreguntaex11").rateit('value'),
                                        preguntaex12: $("#ratepreguntaex12").rateit('value'),
                                        preguntaex13: $("#ratepreguntaex13").rateit('value'),
                                        preguntaex14: $("#ratepreguntaex14").rateit('value'),
                                        ratedimedu: $("#ratedimedu").rateit('value'),
                                        ratedimcont: $("#ratedimcont").rateit('value'),
                                        ratedimeste: $("#ratedimeste").rateit('value'),
                                        ratedimfunc: $("#ratedimfunc").rateit('value'),
                                        ratedimmeta: $("#ratedimmeta").rateit('value'),
                                        id_repository: idrepositori,
                                        id_lom: idlom
                                    }
                                });
                                $(this).dialog("close");
                            },
                            Cancel: function() {

                                $(this).dialog("close");

                            }

                        }


            });
        } else {
            $("#ratepregunta1").rateit('reset');
            $("#ratepregunta2").rateit('reset');
            $("#ratepregunta3").rateit('reset');
            $("#ratepregunta4").rateit('reset');
            $("#ratepregunta5").rateit('reset');
            $("#ratepregunta6").rateit('reset');
            $("#ratepregunta7").rateit('reset');
            $("#evaluacionoas").dialog({
                autoOpen: true,
                show: {
                    effect: "blind",
                    duration: 500
                },
                hide: {
                    effect: "explode",
                    duration: 500
                },
                width: 700,
                height: 500,
                buttons:
                        {
                            "Enviar Calificación": function() {
                                $.ajax({
                                    url: "<?php echo base_url() ?>index.php/usuario/evaluation_user/",
                                    data: {
                                        pregunta1: $("#ratepregunta1").rateit('value'),
                                        pregunta2: $("#ratepregunta2").rateit('value'),
                                        pregunta3: $("#ratepregunta3").rateit('value'),
                                        pregunta4: $("#ratepregunta4").rateit('value'),
                                        pregunta5: $("#ratepregunta5").rateit('value'),
                                        pregunta6: $("#ratepregunta6").rateit('value'),
                                        pregunta7: $("#ratepregunta7").rateit('value'),
                                        idrepository: idrepositori,
                                        idlom: idlom
                                    }
                                });
                                $(this).dialog("close");
                            },
                            Cancel: function() {
                                $(this).dialog("close");
                            }

                        }


            });
        }


    }

    
</script>

<script>
$("#prueba").hide();
    $("#prueba").text("<?php echo urlencode($p) ?>");
    $("#recomendacion").load("<?php echo base_url(); ?>index.php/busqueda/llenar_recomendacion/" + $("#prueba").text() + "");

</script>
