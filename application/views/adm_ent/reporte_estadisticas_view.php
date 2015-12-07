<script>
    $(function() {
        $("#tabs").tabs();
    });
</script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages: ["corechart"]});
//    google.setOnLoadCallback(drawChart1);
    function graficos(idrepository, nom_repository) {
        var parametros = {'repositorio': idrepository};
        var jsonData = $.ajax({
            url: "<?php echo base_url() ?>index.php/adm_repo/graficos/",
            dataType: "json",
            data: parametros,
            async: false
        }).responseText;
        if (jsonData[0][1] == null)
            var obj = jQuery.parseJSON(jsonData);
        $('#mostrargraficos' + idrepository).show();
        var data = google.visualization.arrayToDataTable(obj);

        var options = {
            title: 'Grafico para el repositorio'
        };

        $("mostrargraficos" + idrepository).show();
        var chart = new google.visualization.LineChart(
                document.getElementById('mostrargraficos' + idrepository));
        chart.draw(data, options);


    }

</script>
<script>
    google.load("visualization", "1", {packages: ["corechart"]});
//    google.setOnLoadCallback(drawChart1);
    function oas() {
        var idrepository = $('#oas_consul').val();
        var nom_repository = $('#oas_consul option:selected').text();
        
        var parametros = {'repositorio': idrepository};
        var jsonData = $.ajax({
            url: "<?php echo base_url() ?>index.php/adm_repo/reporte_descargados/",
            dataType: "json",
            data: parametros,
            async: false
        }).responseText;

        try {
            jQuery.parseJSON(jsonData);
            var exito = 'si';
        }
        catch (e) {
            var exito = 'no';
        }

        if (exito == 'si') {
            var obj = jQuery.parseJSON(jsonData);
            var data = google.visualization.arrayToDataTable(obj);
            $('#mostraroas').show();
            var options = {
                title: 'Grafico para el repositorio ' + nom_repository
            };
            var chart = new google.visualization.BarChart(
                    document.getElementById('mostraroas'));
            chart.draw(data, options);

        }
        else {

        }
    }
</script>

<script type="text/javascript">
    $(function() {

        $("#fechainicio").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            dateFormat: "yy-mm-dd",
            onClose: function(selectedDate) {
                $("#fechafin").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#fechafin").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            dateFormat: "yy-mm-dd",
            onClose: function(selectedDate) {
                $("#fechainicio").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
</script>

<script type="text/javascript">
    google.load("visualization", "1", {packages: ["corechart"]});
//    google.setOnLoadCallback(drawChart1);
    function grafico_perso() {
        var idrepository = $('#repo_consul').val();
        var fechainicio = $('#fechainicio').val();
        var fechafin = $('#fechafin').val();
//        var fechainicio = toString($('#fechainicio').val());
//        var fechafin = toString($('#fechafin').val());
        var parametros = {'idrepository': idrepository,
            'fechainicio': fechainicio,
            'fechafin': fechafin
        };
        var jsonData = $.ajax({
            url: "<?php echo base_url() ?>index.php/adm_repo/grafico_personalizado/",
            dataType: "json",
            data: parametros,
            async: false
        }).responseText;

        var obj = jQuery.parseJSON(jsonData);
        var data = google.visualization.arrayToDataTable(obj);

        var options = {
            title: 'Grafico para el repositorio '
        };
        $('#grafico_perso').show();
        var chart = new google.visualization.LineChart(
                document.getElementById('grafico_perso'));
        chart.draw(data, options);


    }

</script>
<section id="main" class="column">

    <article class="module width_full">
        <header><h3>Reportes y Estadisticas</h3></header>
        <div class="module_content" id="tabs">
            <ul>
                <li><a href="#tabs-1">Gráficos De Crecimiento</a></li>
                <li><a href="#tabs-2">Consulta Personalizada de Crecimiento</a></li>
                <li><a href="#tabs-3">Gráficos OAS Mas Descargados</a></li>
            </ul>

            <div id="tabs-1">
                <?php for ($i = 1; $i <= (int) $num_repos[0]['numero']; $i++) { ?>
                    <div id="mostrargraficos<?php echo $nom_repos[$i - 1]['idrepository'] ?>" style="width: 900px; height: 350px; display: none;">
                        <script type="text/javascript">
                            window.onload = graficos(<?php echo $nom_repos[$i - 1]['idrepository'] ?>, "<?php echo $nom_repos[$i - 1]['name'] ?>");
                        </script>

                    </div>
                <?php }?>
               

            </div>

            <div id="tabs-2">
                <table>
                    <tr>
                        <th>
                            Repositorio
                        </th>
                        <th>
                            Fecha Inicio
                        </th>
                        <th>
                            Fecha Final
                        </th>
                        <th>
                            Acción
                        </th>
                    </tr>
                    <tbody>
                        <tr>
                            <td>
                                <select id="repo_consul" name="repo_consul">
                                    <?php foreach ($nom_repos as $key) { ?>
                                        <option value="<?php echo $key['idrepository'] ?>"><?php echo $key['name'] ?>                      
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="inputext1" id="fechainicio" nastraroase="fechainicio">
                            </td>
                            <td>
                                <input type="text" class="inputext1" id="fechafin" name="fechafin"> 
                            </td>
                            <td>
                                <input type="submit" id="perso_grafico" onclick="grafico_perso();" name="perso_grafico" value="Desplegar Gráfico" />
                            </td>
                        </tr>

                    </tbody>    
                </table>
                <div id="grafico_perso" style="width: 900px; height: 350px; display: none;">
                </div>
            </div>

            <div id="tabs-3">
                <table>
                    <tr>
                        <th>Repositorio</th>
                        <th>Acción</th>
                    </tr>
                    <tr>
                        <td>
                            <select id="oas_consul" name="oas_consul">
                                <option value="0">Top 10 OAs Mas Descargados</option>
                                <?php foreach ($nom_repos as $key) { ?>
                                    <option value="<?php echo $key['idrepository'] ?>"><?php echo $key['name'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="submit" id="grafico_oas" onclick="oas();" name="oas_grafico" value="Desplegar Gráfico OAs" /></td>
                    </tr>
                </table>
                <div id="mostraroas" style="width: 900px; height: 350px; display: none;" ></div>
                
            </div>


        </div>
    </article>
    <div class="spacer"></div>
</section>

