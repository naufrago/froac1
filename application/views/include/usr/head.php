<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
    <head>       
        <link rel="stylesheet" href="<?php echo base_url() ?>lib/dtables/media/css/demo_page.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>lib/dtables/media/css/demo_table_jui.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>lib/css/custom-theme/jquery-ui-1.10.1.custom.css"; type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>css/ratingbar.css" type="text/css" media="screen"/>
        <script type="text/javascript" language="javascript" src="<?php echo base_url() ?>lib/dtables/media/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url() ?>lib/dtables/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url() ?>lib/js/jquery.validate.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url() ?>lib/js/jquery-ui-1.10.1.custom.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>lib/raty/lib/jquery.raty.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>lib/js/jquery.ratingbar.js"></script>
        
            
        <meta property="og:site_name" content="Federación de Repositorios de Objetos de Aprendizaje" />

        <meta property="og:url" content="http://froac.manizales.unal.edu.co/froac/" />
        <meta property="og:title" content="Federación de Repositorios de Objetos de Aprendizaje" />

        <meta name="geo.region" content="CO" />
        <meta name="Language" content="Spanish" />

        <meta name="description" content="FROAC es la sigla en español de la Federación de Repositorios de Objetos de Aprendizaje de Colombia, que surge como resultado del proyecto de investigación financiado por COLCIENCIAS titulado: “ROAC Creación de un modelo para la Federación de OA en Colombia que permita su integración a confederaciones internacionales”, de la Universidad Nacional de Colombia, con código 1119-521-29361."/>
        <meta name="keywords" content="Federación Repositorios de Objetos de Aprendizaje, Objetos de Aprendizaje, Universidad Nacional de Colombia, Manizales, Material Educativo, Estilos de aprendizaje, Recursos educativos, Educación, IEEE-LOM, Metadatos, FROAC"/>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $title ?> | FROAC </title>

        <link rel="stylesheet" href="<?php echo base_url() ?>css/froac/style.css" type="text/css" media="screen" />
        <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->

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
        <script type="text/javascript" src="<?php echo base_url() ?>/css/froac/script.js"></script>
        <style>
            /* div container containing the form  */
            #searchContainer {
                margin:20px;
            }

            /* Style the search input field. */
            #field {
                width:500px;
                height:27px;
                line-height:27px;
                text-indent:10px;
                font-family:arial, sans-serif;
                font-size:1em;
                color:#333;
                background: #fff;
                border:solid 1px #d9d9d9;
                border-top:solid 1px #c0c0c0;

            }


            /* Syle the search button. Settings of line-height, font-size, text-indent used to hide submit value in IE */
            #submit {
                cursor:pointer;
                width:70px;
                height: 31px;
                line-height:0;
                font-size:0;
                text-indent:-999px;
                color: transparent;
                background: url(<?php echo base_url() ?>/css/froac/images/ico-search.png) no-repeat #E95A07 center;
                border: 1px solid #E95A07;
                -moz-border-radius: 2px;
                -webkit-border-radius: 2px;
            }
            #submit2 {
                cursor:pointer;
                width:70px;
                height: 40px;
                line-height:0;
                font-size:0;
                text-indent:-999px;
                color: transparent;
                background: url(<?php echo base_url() ?>/css/froac/images/ico-search.png) no-repeat #E95A07 center;
                border: 1px solid #E95A07;
                -moz-border-radius: 2px;
                -webkit-border-radius: 2px;
            }
            /* Style the search button hover state */
            #submit:hover {
                background: url(<?php echo base_url() ?>/css/froac/images/ico-search.png) no-repeat center #E95A07;
                border: 1px solid #2F5BB7;
            }
            #submit2:hover {
                background: url(<?php echo base_url() ?>/css/froac/images/ico-search.png) no-repeat center #E95A07;
                border: 1px solid #2F5BB7;
            }
            /* Clear floats */
            .fclear {clear:both}
        </style>
        <script>
            $(function() {
                $(".btne")
                        .button();

            });
        </script> 
        <link href="<?php echo base_url() ?>/css/froac/images/frog.png" rel="icon" />

    </head>
    <body>

        <div id="art-main">
            <div class="art-sheet">
                <div class="art-sheet-cc"></div>
                <div class="art-sheet-body">