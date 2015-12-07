<?php $cantidad = intval($cant)?>
<script type="text/javascript">
    $(document).ready(function() {

        //Cuando Carga->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

       
        var lim1 = <?php echo $limit1 ?>;
        var lim2 = <?php echo $limit2 ?>;
        var pag = 1;
        $("#pag").text('Pagina ' + pag);

        $.post("<?php echo base_url() ?>index.php/oas/total_reg/" + lim1 + "/" + lim2, function(respuesta) {
            $("#total").text(respuesta);
        });
        $("#contenido").load("<?php echo base_url(); ?>index.php/oas/oasg/" + lim1 + "/" + lim2)

        //Siguiente->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


        $("#next,#next2").click(function() {
            lim2 = lim2 + 10;
        
            $.post("<?php echo base_url() ?>index.php/oas/total_reg/" + lim1 + "/" + lim2, function(respuesta) {
                $("#total").text(respuesta);
            });
            if ($("#total").text() < 10) {
                $("#back, #back2").show();
                $("#next, #next2").hide();
                $("#pag").text('Pagina ' + pag);
                $("#contenido").load("<?php echo base_url(); ?>index.php/oas/oasg/" + lim1 + "/" + lim2-10)


            } else {
                pag++;
                $("#back, #back2").show();
                
                $("#pag").text('Pagina ' + pag);
                $("#contenido").load("<?php echo base_url(); ?>index.php/oas/oasg/" + lim1 + "/" + lim2)
            }

        });


//Atras->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


        $("#back, #back2").click(function() {
            if (lim2 != 0) {
                $.post("<?php echo base_url() ?>index.php/oas/total_reg/" + lim1 + "/" + lim2, function(respuesta) {
                    $("#total").text(respuesta);
                });
                pag--;
                $("#back, #back2").show();
                $("#next, #next2").show();
                lim2 = lim2 - 10;
                $("#pag").text('Pagina ' + pag);
                $("#contenido").load("<?php echo base_url(); ?>index.php/oas/oasg/" + lim1 + "/" + lim2)
            } else {
                $("#contenido").load("<?php echo base_url(); ?>index.php/oas/oasg/" + lim1 + "/" + lim2)
                $("#back, #back2").hide();
            }
        });




    });




</script>
Recuperados <label id="total"></label>
Objetos de <?php echo $cant ?> 

<input type="button" id="back" value="Atras">
<input type="button" id="next" value="Siguiente">


<div id="pag" style="float: right;"></div>
<hr>
<div id="contenido"></div>
<hr>

<input type="button" id="bac2k" value="Atras">
<input type="button" id="next2" value="Siguiente">

<br><br><br><br>
