<?php
if ($label == "R") {
    $contenido = base_url() . 'index.php/oas/oasr/' . $id_rep . '/';
    $total = base_url() . 'index.php/oas/total_reg_r/' . $id_rep . '/';
} else if ($label == "N") {
    $contenido = base_url() . 'index.php/oas/oasg/';
    $total = base_url() . 'index.php/oas/total_reg/';
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#total").hide();
        //Cuando Carga->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


        var lim1 = <?php echo $limit1 ?>;
        var lim2 = <?php echo $limit2 ?>;
        var pag = 1;
        $("#pag").text('Pagina ' + pag);

        $.post("<?php echo $total ?>" + lim1 + "/" + lim2, function(respuesta) {
            $("#total").text(respuesta);
        });
        $("#contenido").load("<?php echo $contenido ?>" + lim1 + "/" + lim2)

        //Siguiente->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


        $("#next,#next2").click(function() {
            lim2 = lim2 + 10;

            $.post("<?php echo $total ?>" + lim1 + "/" + lim2, function(respuesta) {
                $("#total").text(respuesta);
            });
            if ($("#total").text() < 10) {
                $("#back, #back2").show();
                $("#next, #next2").hide();
                $("#pag").text('Pagina ' + pag);
                $("#contenido").load("<?php echo $contenido ?>" + lim1 + "/" + lim2 - 10)


            } else {
                pag++;
                $("#back, #back2").show();

                $("#pag").text('Pagina ' + pag);
                $("#contenido").load("<?php echo $contenido ?>" + lim1 + "/" + lim2)
            }

        });


//Atras->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


        $("#back, #back2").click(function() {
            if (lim2 != 0) {
                $.post("<?php echo $total ?>" + lim1 + "/" + lim2, function(respuesta) {
                    $("#total").text(respuesta);
                });
                pag--;
                $("#back, #back2").show();
                $("#next, #next2").show();
                lim2 = lim2 - 10;
                $("#pag").text('Pagina ' + pag);
                $("#contenido").load("<?php echo $contenido ?>" + lim1 + "/" + lim2)
            } else {
                $("#contenido").load("<?php echo $contenido ?>" + lim1 + "/" + lim2)
                $("#back, #back2").hide();
            }
        });


            

    });




</script>
<label id="total"></label>


<input type="button" id="back" value="Atras">
<input type="button" id="next" value="Siguiente">


<div id="pag" style="float: right;"></div>
<hr>
<div id="contenido"></div>
<hr>

<input type="button" id="bac2k" value="Atras">
<input type="button" id="next2" value="Siguiente">

<br><br><br><br>
