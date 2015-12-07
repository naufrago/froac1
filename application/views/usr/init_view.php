<style>
    #dvLoading
    {
        background: url(<?php echo base_url()?>css/img/36.gif) no-repeat center center;
        height: 100px;
        width: 100px;
        position: fixed;
        left: 56%;
        top: 60%;
        margin: -25px 0 0 -25px;
    }

</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dvLoading').hide();
        $("#submit").click(function() {
            $("#contenido").load("<?php echo base_url(); ?>index.php/busqueda/query/" + $("#field").val().trim().replace(/ /g, '|'));
            


        });

        $(document).keypress(function(e) {
            if (e.which == 13) {
                $("#contenido").load("<?php echo base_url(); ?>index.php/busqueda/query/" + $("#field").val().trim().replace(/ /g, '|'));
              
            }
        });

        $('#submit2').click(function() {
        var form_data = $('#form_avan').serializeArray();
        $.post("<?php echo base_url() ?>index.php/busqueda/check_element", form_data, function(respuesta) {

            alert(respuesta);
            $("#contenido").load("<?php echo base_url(); ?>index.php/busqueda/busqueda_avanzada/"+respuesta);
        });
        });
    });


</script>


<div id="contenido"></div>
<div id="dvLoading"></div>

