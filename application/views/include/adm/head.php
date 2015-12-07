<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <title><?php echo $title; ?></title>

        <link rel="stylesheet" href="<?php echo base_url() ?>css/adm/css/layout.css" type="text/css" media="screen" />
        <!--[if lt IE 9]>
        <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!--<script src="//php echo base_url() ?>css/adm/js/jquery-1.5.2.min.js" type="text/javascript"></script>-->
        <script src="<?php echo base_url() ?>css/adm/js/jquery-1.9.1.js" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php echo base_url() ?>css/adm/css/south-street/jquery-ui-1.10.3.custom.css" type="text/css" media="screen"/>
        <script src="<?php echo base_url() ?>css/adm/js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
        <link href="<?php echo base_url() ?>/css/froac/images/frog.png" rel="icon" />
        <script src="<?php echo base_url() ?>css/adm/js/hideshow.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>css/adm/js/jquery.tablesorter.min.js" type="text/javascript"></script>

        <script type="text/javascript" src="<?php echo base_url() ?>css/adm/js/jquery.equalHeight.js"></script>
        <meta property="og:site_name" content="Federación de Repositorios de Objetos de Aprendizaje" />

        <meta property="og:url" content="http://froac.manizales.unal.edu.co/froac/" />
        <meta property="og:title" content="Federación de Repositorios de Objetos de Aprendizaje" />

        <meta name="geo.region" content="CO" />
        <meta name="Language" content="Spanish" />

        <meta name="description" content="FROAC es la sigla en español de la Federación de Repositorios de Objetos de Aprendizaje de Colombia, que surge como resultado del proyecto de investigación financiado por COLCIENCIAS titulado: “ROAC Creación de un modelo para la Federación de OA en Colombia que permita su integración a confederaciones internacionales”, de la Universidad Nacional de Colombia, con código 1119-521-29361."/>
        <meta name="keywords" content="Federación Repositorios de Objetos de Aprendizaje, Objetos de Aprendizaje, Universidad Nacional de Colombia, Manizales, Material Educativo, Estilos de aprendizaje, Recursos educativos, Educación, IEEE-LOM, Metadatos, FROAC"/>
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-40629793-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();

        </script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                $(".tablesorter").tablesorter();
            }
            );
            $(document).ready(function() {

                //When page loads...
                $(".tab_content").hide(); //Hide all content
                $("ul.tabs li:first").addClass("active").show(); //Activate first tab
                $(".tab_content:first").show(); //Show first tab content

                //On Click Event
                $("ul.tabs li").click(function() {

                    $("ul.tabs li").removeClass("active"); //Remove any "active" class
                    $(this).addClass("active"); //Add "active" class to selected tab
                    $(".tab_content").hide(); //Hide all tab content

                    var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
                    $(activeTab).fadeIn(); //Fade in the active ID content
                    return false;
                });

            });
        </script>
        <script type="text/javascript">
            $(function() {
                $('.column').equalHeight();
            });
        </script>
        <script>
            $(function($) {
                $.datepicker.regional['es'] = {
                    closeText: 'Cerrar',
                    prevText: '<Ant',
                    nextText: 'Sig>',   
                    currentText: 'Hoy',
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                    weekHeader: 'Sm',
                    dateFormat: 'dd/mm/yy',
                    firstDay: 1,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ''
                };
                $.datepicker.setDefaults($.datepicker.regional['es']);
            });
        </script>
    </head>


    <body>