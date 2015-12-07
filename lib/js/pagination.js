$(document).ready(function() {
        var lim1 = <?php echo $limit1 ?>;
        var lim2 = <?php echo $limit2 ?>;

 $.post("<?php echo base_url() ?>index.php/oas/total_reg/" + lim1 + "/" + lim2, function(respuesta) {
    $("#total").val(respuesta); 
    });
        $("#contenido").load("<?php echo base_url(); ?>index.php/oas/oasg/" + lim1 + "/" + lim2)

        $("#next,#next2").click(function() {
            $("#back, #back2").show();
            lim2 = lim2 + 10;
            $("#contenido").load("<?php echo base_url(); ?>index.php/oas/oasg/" + lim1 + "/" + lim2)
        });

        $("#back, #back2").click(function() {
            if (lim2 != 0) {
                lim2 = lim2 - 10;
                $("#back, #back2").show();
                $("#contenido").load("<?php echo base_url(); ?>index.php/oas/oasg/" + lim1 + "/" + lim2)
            } else {
                $("#contenido").load("<?php echo base_url(); ?>index.php/oas/oasg/" + lim1 + "/" + lim2)
                $("#back, #back2").hide();
            }
        });

    });



