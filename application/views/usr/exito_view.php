<script type="text/javascript">
    $(document).ready(function() {
$('#pass').hide();
$('#2').hide();
  $('#1').click(function() {
            $('#pass').show();
            $('#1').hide();
            $('#2').show();
        });
          });

</script>
<div class="art-postcontent">
    <h1>Registro exitoso !!</h1><br>
    <h4>Bienvenido a FROAC, <?php echo $name ?></h4>
    <br>
    <form autocomplete="off" action="<?php echo base_url() ?>index.php/usuario/check" method="post" name="login" id="form-login" >

        <h5>Desea iniciar su sesión</h5>
        <input type="button" value="Iniciar sesión" class="btne" id="1">
        <input type="hidden" name="username"  alt="username" size="18" value="<?php echo $username ?>" />
        <span id="pass" >Password: <input type="password" name="passwd" id="passwd" alt="username" autocomplete="off" size="18" value="" /></span> 
        <input type="submit" value="Iniciar sesión" class="btne" id="2">
    </form> 
    <a href="<?php echo base_url() ?>"><input type="button" value="No, tal vez mas tarde" class="btne"></a>

