<script type="text/javascript">
    $('#field').val('<?php echo $busqueda?>'); 
    $(document).ready(function() {

        $("#submit").click(function() {
            $("#contenido").load("<?php echo base_url(); ?>index.php/busqueda/query/" + $("#field").val().replace(/ /g, '-'));
        });
        $("#submit").click();
        
        $(document).keypress(function(e) {
            if (e.which == 13) {
                $("#contenido").load("<?php echo base_url(); ?>index.php/busqueda/query/" + $("#field").val().replace(/ /g, '-'));
            }
        });
    });


</script>
<div id="contenido"></div>
