<section id="main" class="column">

    <div class="spacer"></div>

    <article class="module width_full">

        <header><h3>Insertar Usuario Administrador de Repositorio</h3></header>
        <div class="module_content">
            <div id="tab1" class="tab_content">
                <article class="module width_full">
                    <form autocomplete="off" action="<?php echo base_url() ?>index.php/modificar_user_repo/" enctype="multipart/form-data" method="post">
                        <fieldset>
                            <label>Nombre</label><br>
                            <input type="text" name="nombreuser" id="nombreuser" /><br>
                            <label>Apellido</label><br>
                            <input type="text" name="apellidouser" id="apellidouser"/><br>                            
                            <label>Username</label><br>
                            <input type="text" name="Username" id="Username"/><br>
                            <label>Contraseña</label><br>
                            <input type="password" name="contraseña" autocomplete="off"/><br>
                            <label>Repita Contraseña</label><br>
                            <input type="password" name="contraseña1" autocomplete="off"/><br>
                            <label>Email</label><br>
                            <input type="text" name="email" id="email"/><br>
                        </fieldset>
                    </form>
                </article>
            </div >
            <footer>
                <div class="submit_link">

                    <input type="submit" id="enviar"  value="Guardar" class="alt_btn">
                    <input type="submit" id="reset" value="Reset" onclick="reloadpage();">
                </div>
            </footer>


        </div>



        </div>
        <script>
            
            $("#reset").click(function (){
              window.location = "<?php echo base_url()?>adm_repo/nuevo_usuario_repo/";  
            });

            function alertdialog(texto, input, exito) {

                $("#dialogoalert").dialog({
                    autoOpen: true,
                    show: {
                        effect: "blind",
                        duration: 500
                    },
                    hide: {
                        effect: "explode",
                        duration: 500
                    },
                    width: 400,
                    buttons: [
                        {
                            text: texto,
                            click: function() {
                                $(this).dialog("close");
                                $("#" + input).focus();

                            }
                        }
                    ]
                });
            }



            function alertdialog1(texto, input, exito) {

                $("#dialogoalert").dialog({
                    autoOpen: true,
                    show: {
                        effect: "blind",
                        duration: 500
                    },
                    hide: {
                        effect: "explode",
                        duration: 500
                    },
                    width: 400,
                    buttons: [
                        {
                            text: texto,
                            click: function() {
                                $(this).dialog("close");
                                $("#" + input).focus();
                                window.location = "<?php echo base_url() ?>adm_repo/lista_users_repos/";
                            }
                        }
                    ]
                });
            }
            

            $("#enviar").click(function() {
                if ($("#nombreuser").val() == "") {
                    $("#dialogoalert").html("<p>Por favor ingrese el nombre </p>");
                    alertdialog("Ok", "nombreuser", "Error campo vacio");
                    return false;
                }
                if ($("#apellidouser").val() == "") {
                    $("#dialogoalert").html("<p>Por favor ingrese el apellido</p>");
                    alertdialog("Ok", "apellidouser", "Error campo vacio");
                    return false;
                }
                if ($("#Username").val() == "") {
                    $("#dialogoalert").html("<p>Por favor ingrese el nombre el nombre de usuario para loguearse</p>");
                    alertdialog("Ok", "Username", "Error campo vacio");
                    return false;
                }
                if ($("#contraseña").val() == "") {
                    $("#dialogoalert").html("<p> Ingrese la contraseña </p>");
                    alertdialog("Ok", "contraseña", "Error campo vacio");
                    return false;
                }
                if ($("#contraseña1").val() === "") {
                    $("#dialogoalert").html("<p>Por favor repita su contraseña</p>");
                    alertdialog("Ok", "contraseña1", "Error campo vacio");
                    return false;
                }

                if ($("#contraseña").val() === $("#contraseña1").val()) {
                    var data = {nombre: $("#nombreuser").val(), apellido: $("#apellidouser").val(),
                        username: $("#Username").val(), password: $("#contraseña").val(), email: $("#email").val()
                    };
                    $.ajax({
                        url: "<?php echo base_url() ?>index.php/adm_repo/agregar_nuevo_user_repo/",
                        type: "POST",
                        data: data
                    }).done(function() {
                        $("#dialogoalert").html("<p>Se ha agregado un nuevo usuario repositorio</p>");
                        alertdialog1("Ok", "email", "Éxito");


                    }).fail(function() {
                        $("#dialogoalert").html("<p>Existe un problema en el servidor intente de nuevo</p>");
                        alertdialog("Ok", "email", "No se ha podido ejecutar la actualización");
                    });
                } else {
                    $("#dialogoalert").html("<p>Las Constraseñas no coinciden</p>");
                    alertdialog("Ok", "contraseña", "Problema con las contraseñas");
                }

            });
        </script>

    </article>
</section>
<div id="dialogoalert">

</div>