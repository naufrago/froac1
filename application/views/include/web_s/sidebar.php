<script>
    $(function() {
        $("#bto").button();
    });

</script>
<div class="art-vmenublockcontent-body">
    <ul class="art-vmenu">
        <li>
            <a href="<?php echo base_url(); ?>">         <span class="l"></span><span class="r"></span><span class="t">Buscar</span></a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>oas/">     <span class="l"></span><span class="r"></span><span class="t">OA'S</span></a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>init/build"><span class="l"></span><span class="r"></span><span class="t">Manuales</span></a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>init/build"><span class="l"></span><span class="r"></span><span class="t">Eventos</span></a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>init/build"><span class="l"></span><span class="r"></span><span class="t">Foro</span></a>
        </li>
        
    </ul>

    <div class="cleared"></div>
</div>
</div>
<div class="cleared"></div>
</div>
</div>
<br><br><br>
<div class="art-block" >
    <div class="art-block-body">
        <div class="art-blockheader">
            <h3 class="t">Iniciar Sesión</h3>
        </div>
        <div class="art-blockcontent">
            <div class="art-blockcontent-body">
                <form action="<?php echo base_url()?>index.php/usuario/check" method="post" name="login" id="form-login" >
                    <fieldset class="input">
                        <p id="form-login-username">
                            <label for="modlgn_username">Nombre de usuario</label><br />
                            <input id="modlgn_username" type="text" name="username" class="inputbox" alt="username" size="18" />
                        </p>
                        <p id="form-login-password">
                            <label for="modlgn_passwd">Password</label><br />
                            <input id="modlgn_passwd" type="password" name="passwd" class="inputbox" size="18" alt="password" />
                        </p>


                        <span class="art-button-wrapper">
                            <span class="art-button-l"> </span>
                            <span class="art-button-r"> </span>
                            <input type="submit" name="Submit"  value="Entrar" id="bto"/>
                        </span>
                    </fieldset>
                    <ul>
                        <li><a href="#">Olvide mi contraseña</a></li>
                        <li><a href="<?php echo base_url() ?>usuario/">Registrarse</a></li>
                    </ul>
                </form>

                <div class="cleared"></div>
            </div>
        </div>
        <div class="cleared"></div>
    </div>
</div>
<div class="cleared"></div>
</div>

<div class="art-layout-cell art-content">
    <div class="art-post">
        <div class="art-post-body">
