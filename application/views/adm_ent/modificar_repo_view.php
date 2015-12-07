<script type="text/javascript" language="javascript">
    function verificampos() {
        if ($('#tiporepositorio').val() == 'ROAp') {

            if (document.getElementById("nombrerepositorio").value == "") {
                alert("Por favor ingrese el nombre del repositorio");
                document.getElementById("nombrerepositorio").focus();
                return false;
            }
            if (document.getElementById("entidad").value == "") {
                alert("Por favor ingrese el nombre de la institucion");
                document.getElementById("entidad").focus();
                return false;
            }
            if (document.getElementById("email").value == "") {
                alert("Por favor ingrese el email");
                document.getElementById("email").focus();
                return false;
            }
            if (document.getElementById("basededatos").value == "") {
                alert("Por favor favor ingrese el nombre de la base de datos");
                document.getElementById("basededatos").focus();
                return false;
            }
            if (document.getElementById("usuario").value == "") {
                alert("Por favor favor ingrese el nombre de usuario");
                document.getElementById("usuario").focus();
                return false;
            }
            if (document.getElementById("contrasena").value == "") {
                alert("Por favor favor favor ingrese la contraseña");
                document.getElementById("contrasena").focus();
                return false;
            }
            
            if (document.getElementById("puerto").value == "") {
                alert("Por favor ingrese el puerto");
                document.getElementById("puerto").focus();
                return false;
            }
            if (document.getElementById("host").value == "") {
                alert("Por favor ingrese el host");
                document.getElementById("host").focus();
                return false;
            }
            if (document.getElementById("url").value == "") {
                alert("Por favor ingrese la URL");
                document.getElementById("url").focus();
                return false;
            }
        }

        if ($('#tiporepositorio').val() == 'OAI') {
            if (document.getElementById("nombrerepositorio").value == "") {
                alert("Por favor ingrese el nombre del repositorio");
                document.getElementById("nombrerepositorio").focus();
                return false;
            }
            if (document.getElementById("entidad").value == "") {
                alert("Por favor ingrese el nombre de la institucion");
                document.getElementById("entidad").focus();
                return false;
            }
            if (document.getElementById("email").value == "") {
                alert("Por favor ingrese el email");
                document.getElementById("email").focus();
                return false;
            }
            if (document.getElementById("url").value == "") {
                alert("Por favor ingrese la URL");
                document.getElementById("url").focus();
                return false;
            }
            if (document.getElementById("host").value == "") {
                alert("Por favor ingrese el Enlace OAI");
                document.getElementById("host").focus();
                return false;
            }

            if (document.getElementById("metadata").value == "") {
                alert("Por favor ingrese estandar metadatos");
                document.getElementById("metadata").focus();
                return false;
            }
            if (document.getElementById("periodicidad").value == "") {
                alert("Por favor ingrese una periodicidad");
                document.getElementById("periodicidad").focus();
                return false;
            }

            if (document.getElementById("codigov").value == "") {
                alert("Por favor favor ingrese el codigo de verificacion");
                document.getElementById("codigov").focus();
                return false;
            }

        }

    }
</script>

<script>
    $(function() {
        
        if($('#tiporepositorio').val()=='roap'){    
        
                $('#formulario').show();
                $('#lhost').text("Host");
                $('#lmetadata').hide();
                $('#metadata').hide();                
                $('#lpuerto').show();
                $('#puerto').show();
                $('#lbasededatos').show();
                $('#basededatos').show();
                $('#lusuario').show();
                $('#usuario').show();
                $('#lcontrasena').show();
                $('#contrasena').show();
                $('#lperiodicidad').show();
                $('#periodicidad').show();
        }
        else{
            if($('#tiporepositorio').val()=='otro'){
                $('#formulario').show();
                $('#lhost').text("Enlace OAI");
                $('#lpuerto').hide();
                $('#puerto').hide();
                $('#lbasededatos').hide();
                $('#basededatos').hide();
                $('#lusuario').hide();
                $('#usuario').hide();
                $('#lcontrasena').hide();
                $('#contrasena').hide();
                $('#lmetadata').show();
                $('#metadata').show();
                $('#lperiodicidad').show();
                $('#periodicidad').show();
            }
        }
    });
    
            
       


</script>
<section id="main" class="column">

    <div class="spacer"></div>

    <article class="module width_full">
        <form autocomplete="off" action="<?php echo base_url() ?>index.php/adm_repo/actualizar_repo/" method="post" onsubmit="return verificampos();" enctype="multipart/form-data">
            <header><h3>MOdificar Repositorio</h3></header>
            <div class="module_content">
                

                <fieldset id="formulario" >
                    <?php foreach ($repomod as $key) { ?>
                        <label>Nombre</label><br>
                        <input type="text" name="nombrerepositorio" id="nombrerepositorio" value="<?php echo $key['name']; ?>" /><br>
                        <label>Entidad</label><br>
                        <input type="text" name="entidad" id="entidad" value="<?php echo $key['affiliation'] ?>" /><br>
                        <label>Correo Electrónico</label><br>
                        <input type="email" value="<?php echo $key['email'] ?>" name="email" id="email"/><br>
                        <label id="ltiporepositorio">Tipo Repositorio</label>
                        <input type="text" disabled="" id="tiporepositorio" name="tiporepositorio" value="<?php echo $key['typerepository']?>">
                        <label>url</label>
                        <input type="text" name="url" value="<?php echo $key['url'] ?>" id="url" /><br>
                        <label id="lhost">Host</label>
                        <input type="text" value="<?php echo $key['host'] ?>" name="host" id="host" /><br>
                        <label id="lmetadata">Estandar de Metadatos</label>
                        <input type="text" name="metadata" id="metadata" value="<?php echo $key['metadata_inf'] ?>" />
                        <label id="lpuerto">Puerto</label><br>
                        <input type="text" name="puerto" id="puerto" value="<?php echo $key['port'] ?>" /><br>
                        <label id="lbasededatos">Base De Datos</label><br>
                        <input type="text" name="basededatos" id="basededatos" value="<?php echo $key['databasename'] ?>" /><br>
                        <label id="lusuario">Usuario</label><br>
                        <input type="text" name="usuario" id="usuario" value="<?php echo $key['loggin'] ?>" /><br>
                        <label id="lcontrasena">Contraseña</label><br>
                        <input type="text" name="contrasena" id="contrasena" value="<?php echo $key['password'] ?>" /><br>
                        <label id="lperiodicidad">Perio. Actualizaciones (días)</label><br>
                        <input type="number" id="periodicidad" name="periodicidad" value="<?php echo $key['frequency'] ?>" /><br>
                        <label>Usuario repositorio</label><br>
                        <select id="usuariorepo" name="usuariorepo">
                            <option value="0">Seleccione Usuario</option>
                            
                            <?php foreach ($usuario as $user) {?>
                            <option value="<?php echo $user['username']; ?>"><?php echo $user['nombre']." ".$user['apellido'];?></option>
                            <?php                            
                            }
                            ?>
                        </select>
                        
                        <input type="hidden" value="<?php echo $key['idrepository'] ?>" name="idrepository" />
                        <input type="hidden" value="<?php echo $key['countoas']?>" name="countoas" />                        
                        <input type="hidden" value="<?php echo $key['registrationdate']?>" name="registrationdate">
                        <?php
                    }
                    ?>


                </fieldset>

            </div>
            <footer>
                <div class="submit_link">
                    <input type="submit"  value="Guardar" class="alt_btn"/> 
                    <input type="reset" value="Cancelar"/>
                </div>
            </footer>
        </form>
    </article>
</section>