

<h2 class="art-postheader">
    Web Service
</h2>

<div class="art-postmetadataheader">

</div>

<div class="art-postcontent">
    <br>
    <h2>
        Término Web Service
    </h2>
    <p>
        <strong>Web Service: </strong>
        Un servicio web (en inglés, Web Service o Web services) es una tecnología 
        que utiliza un conjunto de protocolos y estándares que sirven para intercambiar 
        datos entre aplicaciones. Distintas aplicaciones de software desarrolladas 
        en lenguajes de programación diferentes, y ejecutadas sobre cualquier plataforma, 
        pueden utilizar los servicios web para intercambiar datos en redes de ordenadores
        como Internet. La interoperabilidad se consigue mediante la adopción de estándares
        abiertos. Las organizaciones OASIS y W3C son los comités responsables de la 
        arquitectura y reglamentación de los servicios Web. Para mejorar la interoperabilidad
        entre distintas implementaciones de servicios Web se ha creado el organismo WS-I,
        encargado de desarrollar diversos perfiles para definir de manera más exhaustiva
        estos estándares. Es una máquina que atiende las peticiones de los clientes web
        y les envía los recursos solicitados.
    </p>
    <p>
        <strong>Objetivo Web Service: </strong>
        El objetivo principal del Web Service desarrollado en FROAC es permitir al usuario
        realizar búsquedas desde web personales o desde cualquier otro sitio en internet que 
        haya agregado el servicio dentro de su paginas. Para no interrumpir ningún trabajo 
        el servicio Web hace una búsqueda en una pestaña nueva para no interrumpir el trabajo 
        del usuario quien hace uso de él.
    </p>
    <p>
        <strong>Como conseguir el servicio: </strong>
        Para agregar el servicio web de FROAC a tu pagina debes agregar el siguiente código: 
        <input type="button" value="Código" class="ui-button ui-widget ui-state-default ui-corner-all" onclick="mostrarcodigo();">
        <br>


    </p>

    <script type="text/javascript">

            function mostrarcodigo() {
                $("#dialogo").text('<iframe src="http://froac.manizales.unal.edu.co/froac/web_service/ width="200px"/>');



                $("#dialogo").dialog({
                    autoOpen: true,
                    show: {
                        effect: "blind",
                        duration: 500
                    },
                    hide: {
                        effect: "explode",
                        duration: 500
                    },
                    width: 600,
                    buttons: [
                        {
                            text: 'Ok',
                            click: function() {
                                $(this).dialog("close");

                            }
                        }
                    ]
                });
            }


    </script>

    <div id="dialogo" title="Agrega este código a tu pagina web">

    </div>
</div>