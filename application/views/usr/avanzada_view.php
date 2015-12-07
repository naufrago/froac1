<script>
    $(function() {

        $( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
        $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
        $("#tabs li.ui-state-active a").css("color","#587722")

        $("#tabs").tabs({
            activate: function (event, ui) {
                $("#tabs li.ui-state-default a").css("color","#ffffff");
                $("#tabs li.ui-state-active a").css("color","#587722");
            }
        });

        $("#lang").change(function(){
            if($("#sGeneralLanguage").val() === ""){
                $("#sGeneralLanguage").val($("#lang").val());
            }else{
                var valor = $("#sGeneralLanguage").val()+','+$("#lang").val();
                $("#sGeneralLanguage").val(valor);
            }

        });
    });
</script>
<style>
    .ui-tabs-vertical { width: 55em; }
    .ui-tabs-vertical .ui-tabs-nav {  padding: .2em .1em .2em .2em; float: left; width: 12em; }
    .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0;}
    .ui-tabs-vertical .ui-tabs-nav li a { display:block; color: #ffffff;}
    .ui-tabs-vertical .ui-tabs-panel { margin-left: 200px;}
    .campo{
        width: 150px;
        font-weight: bold;

    }

    .title{
        font-weight: bold;
        bottom: 0; left: 0;
    }
    input[type=text] {
        border: 1px solid #eeeeee;
        border-color: #00620C;
        background-color: #ffffff;
        color: #000000;
        font-color: #000000;
        font-size: 16px;
        font-family: Arial;
        overflow: auto;
        height: 22px;
        width: 400px;
    }

</style>
<form id="form_avan">
<div id="tabs" style="width: 98%" class="style-tabs">
<ul>
    <li><a href="#tabs-1">Basico</a></li>
    <li><a href="#tabs-2">General</a></li>
    <li><a href="#tabs-3">Ciclo de vida</a></li>
    <li><a href="#tabs-4">Meta-metadata</a></li>
    <li><a href="#tabs-5">Técnica</a></li>
    <li><a href="#tabs-6">Uso educativo</a></li>
    <li><a href="#tabs-7">Derechos</a></li>
    <li><a href="#tabs-8">Relación</a></li>
    <li><a href="#tabs-9">Anotación</a></li>
    <li><a href="#tabs-10">Clasificación</a></li>
</ul>
<div id="tabs-1">
    <table>
        <tr>
            <td class="campo"></td>
            <td class="campo"></td>
        </tr>
        <tr>
            <td class="title"><span>Titulo</span></td>

            <td><input type="text" name='lom91general_title'></td>
        </tr>
        <tr>
            <td class="title">Palabras Clave</td>

            <td><input type="text" name="general_keyword91keyword"></td>
        </tr>
        <tr>
            <td class="title">Formato</td>

            <td><input type="text" name="technical_format91format"></td>
        </tr>
        <tr>
            <td class="title"> Subido por</td>

            <td><input type="text" name="FALTA"></td>
        </tr>
    </table>
</div>

<div id="tabs-2">
    <table>
        <tr>
            <td class="campo"></td>

            <td class="campo"></td>
        </tr>
        <tr>
            <td class="title"><span>Catalogo</span></td>

            <td><input type="text" name="general_identifier91catalog"></td>
        </tr>
        <tr>
            <td class="title">Entrada</td>

            <td><input type="text" name="general_identifier91entry"></td>
        </tr>
        <tr>
            <td class="title">Idioma</td>

            <td>
                <input type="text" name="general_language91language" id="sGeneralLanguage">
                <select id="lang">
                    <option value="none">Seleccionar</option>
                    <option value="es">Spanish</option>
                    <option value="en">English</option>
                    <option value="pt">Portuguese</option>
                    <option value="fr">French</option>
                    <option value="ru">Russian</option>
                    <option value="ja">Japanese</option>
                    <option value="la">Latin</option>
                    <option value="aa">Afar</option>
                    <option value="ab">Abkhazian</option>
                    <option value="af">Afrikaans</option>
                    <option value="am">Amharic</option>
                    <option value="ar">Arabic</option>
                    <option value="as">Assamese</option>
                    <option value="ay">Aymara</option>
                    <option value="az">Azerbaijani</option>
                    <option value="ba">Bashkir</option>
                    <option value="be">Byelorussian</option>
                    <option value="bg">Bulgarian</option>
                    <option value="bh">Bihari</option>
                    <option value="bi">Bislama</option>
                    <option value="bn">Bengali;Bangla</option>
                    <option value="bo">Tibetan</option>
                    <option value="br">Breton</option>
                    <option value="ca">Catalan</option>
                    <option value="co">Corsican</option>
                    <option value="cs">Czech</option>
                    <option value="cy">Welsh</option>
                    <option value="da">Danish</option>
                    <option value="de">German</option>
                    <option value="dz">Bhutani</option>
                    <option value="el">Greek</option>
                    <option value="eo">Esperanto</option>
                    <option value="et">Estonian</option>
                    <option value="eu">Basque</option>
                    <option value="fa">Persian</option>
                    <option value="fi">Finnish</option>
                    <option value="fj">Fiji</option>
                    <option value="fo">Faeroese</option>
                    <option value="fy">Frisian</option>
                    <option value="ga">Irish</option>
                    <option value="gd">Scots</option>
                    <option value="gl">Galician</option>
                    <option value="gn">Guarani</option>
                    <option value="gu">Gujarati</option>
                    <option value="ha">Hausa</option>
                    <option value="hi">Hindi</option>
                    <option value="hr">Croatian</option>
                    <option value="hu">Hungarian</option>
                    <option value="hy">Armenian</option>
                    <option value="ia">Interlingua</option>
                    <option value="ie">Interlingue</option>
                    <option value="ik">Inupiak</option>
                    <option value="in">Indonesian</option>
                    <option value="is">Icelandic</option>
                    <option value="it">Italian</option>
                    <option value="iw">Hebrew</option>
                    <option value="ji">Yiddish</option>
                    <option value="jw">Javanese</option>
                    <option value="ka">Georgian</option>
                    <option value="kk">Kazakh</option>
                    <option value="kl">Greenlandic</option>
                    <option value="km">Cambodian</option>
                    <option value="kn">Kannada</option>
                    <option value="ko">Korean</option>
                    <option value="ks">Kashmiri</option>
                    <option value="ku">Kurdish</option>
                    <option value="ky">Kirghiz</option>
                    <option value="ln">Lingala</option>
                    <option value="lo">Laothian</option>
                    <option value="lt">Lithuanian</option>
                    <option value="lv">Latvian,Lettish</option>
                    <option value="mg">Malagasy</option>
                    <option value="mi">Maori</option>
                    <option value="mk">Macedonian</option>
                    <option value="ml">Malayalam</option>
                    <option value="mn">Mongolian</option>
                    <option value="mo">Moldavian</option>
                    <option value="mr">Marathi</option>
                    <option value="ms">Malay</option>
                    <option value="mt">Maltese</option>
                    <option value="my">Burmese</option>
                    <option value="na">Nauru</option>
                    <option value="ne">Nepali</option>
                    <option value="nl">Dutch</option>
                    <option value="no">Norwegian</option>
                    <option value="oc">Occitan</option>
                    <option value="om">(Afan)Oromo</option>
                    <option value="or">Oriya</option>
                    <option value="pa">Punjabi</option>
                    <option value="pl">Polish</option>
                    <option value="ps">Pashto,Pushto</option>
                    <option value="qu">Quechua</option>
                    <option value="rm">Rhaeto-Romance</option>
                    <option value="rn">Kirundi</option>
                    <option value="ro">Romanian</option>
                    <option value="rw">Kinyarwanda</option>
                    <option value="sa">Sanskrit</option>
                    <option value="sd">Sindhi</option>
                    <option value="sg">Sangro</option>
                    <option value="sh">Serbo-Croatian</option>
                    <option value="si">Singhalese</option>
                    <option value="sk">Slovak</option>
                    <option value="sl">Slovenian</option>
                    <option value="sm">Samoan</option>
                    <option value="sn">Shona</option>
                    <option value="so">Somali</option>
                    <option value="sq">Albanian</option>
                    <option value="sr">Serbian</option>
                    <option value="ss">Siswati</option>
                    <option value="st">Sesotho</option>
                    <option value="su">Sundanese</option>
                    <option value="sv">Swedish</option>
                    <option value="sw">Swahili</option>
                    <option value="ta">Tamil</option>
                    <option value="te">Tegulu</option>
                    <option value="tg">Tajik</option>
                    <option value="th">Thai</option>
                    <option value="ti">Tigrinya</option>
                    <option value="tk">Turkmen</option>
                    <option value="tl">Tagalog</option>
                    <option value="tn">Setswana</option>
                    <option value="to">Tonga</option>
                    <option value="tr">Turkish</option>
                    <option value="ts">Tsonga</option>
                    <option value="tt">Tatar</option>
                    <option value="tw">Twi</option>
                    <option value="uk">Ukrainian</option>
                    <option value="ur">Urdu</option>
                    <option value="uz">Uzbek</option>
                    <option value="vi">Vietnamese</option>
                    <option value="vo">Volapuk</option>
                    <option value="wo">Wolof</option>
                    <option value="xh">Xhosa</option>
                    <option value="yo">Yoruba</option>
                    <option value="zh">Chinese</option>
                    <option value="zu">Zulu</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="title">Descripción</td>

            <td><textarea name="general_description91description" style="width: 300px;"></textarea></td>
        </tr>
        <tr>
            <td class="title">Ambito</td>

            <td><input type="text" name="general_coverage91coverage"></td>
        </tr>
        <tr>
            <td class="title">Estructura</td>

            <td><input type="text" name="lom91general_structure"></td>
        </tr>
        <tr>
            <td class="title">Nivel de agregación</td>

            <td><input type="text" name="lom91general_aggregationlevel"></td>
        </tr>
    </table>

</div>
<div id="tabs-3">
    <table>
        <tr>
            <td class="campo"></td>
            <td class="campo"></td>
        </tr>
        <tr>
            <td class="title">Versión</td>

            <td><input type="text" name="lom91lifecycle_version"></td>
        </tr>
        <tr>
            <td class="title">Estado</td>

            <td><input type="text" name="lom91lifecycle_status"></td>
        </tr>
        <tr>
            <td class="title">Rol</td>

            <td><input type="text" name="lifecycle_contribute91role"></td>
        </tr>
        <tr>
            <td class="title">Entidad</td>

            <td><input type="text" name="lifecyclecontribute_entity91entity"></td>
        </tr>
        <tr>
            <td class="title">Fecha</td>

            <td><input type="text" name="lifecycle_contribute91date"></td>
        </tr>
    </table>
</div>
<div id="tabs-4">
    <table>
        <tr>
            <td class="campo"></td>
            <td class="campo"></td>
        </tr>
        <tr>
            <td class="title">Catalogo</td>

            <td><input type="text" name="metametadata_identifier91catalog"></td>
        </tr>
        <tr>
            <td class="title">Entrada</td>

            <td><input type="text" name="metametadata_identifier91entry"></td>
        </tr>
        <tr>
            <td class="title">Rol</td>

            <td><input type="text" name="metametadata_contribute91role"></td>
        </tr>
        <tr>
            <td class="title">Entidad</td>

            <td><input type="text" name="metametadatacontribute_entity91entity"></td>
        </tr>
        <tr>
            <td class="title">Fecha</td>

            <td><input type="text" name="metametadata_contribute91date"></td>
        </tr>
        <tr>
            <td class="title">Esquema de Metadatos</td>

            <td><input type="text" name="metametadata_metadataschema91metadataschema"></td>
        </tr>
        <tr>
            <td class="title">Idioma</td>

            <td>     <input type="text" name="lom91metametadata_language" id="lom91metametadata_language">
                <select id="lang">
                    <option value="none">Seleccionar</option>
                    <option value="es">Spanish</option>
                    <option value="en">English</option>
                    <option value="pt">Portuguese</option>
                    <option value="fr">French</option>
                    <option value="ru">Russian</option>
                    <option value="ja">Japanese</option>
                    <option value="la">Latin</option>
                    <option value="aa">Afar</option>
                    <option value="ab">Abkhazian</option>
                    <option value="af">Afrikaans</option>
                    <option value="am">Amharic</option>
                    <option value="ar">Arabic</option>
                    <option value="as">Assamese</option>
                    <option value="ay">Aymara</option>
                    <option value="az">Azerbaijani</option>
                    <option value="ba">Bashkir</option>
                    <option value="be">Byelorussian</option>
                    <option value="bg">Bulgarian</option>
                    <option value="bh">Bihari</option>
                    <option value="bi">Bislama</option>
                    <option value="bn">Bengali;Bangla</option>
                    <option value="bo">Tibetan</option>
                    <option value="br">Breton</option>
                    <option value="ca">Catalan</option>
                    <option value="co">Corsican</option>
                    <option value="cs">Czech</option>
                    <option value="cy">Welsh</option>
                    <option value="da">Danish</option>
                    <option value="de">German</option>
                    <option value="dz">Bhutani</option>
                    <option value="el">Greek</option>
                    <option value="eo">Esperanto</option>
                    <option value="et">Estonian</option>
                    <option value="eu">Basque</option>
                    <option value="fa">Persian</option>
                    <option value="fi">Finnish</option>
                    <option value="fj">Fiji</option>
                    <option value="fo">Faeroese</option>
                    <option value="fy">Frisian</option>
                    <option value="ga">Irish</option>
                    <option value="gd">Scots</option>
                    <option value="gl">Galician</option>
                    <option value="gn">Guarani</option>
                    <option value="gu">Gujarati</option>
                    <option value="ha">Hausa</option>
                    <option value="hi">Hindi</option>
                    <option value="hr">Croatian</option>
                    <option value="hu">Hungarian</option>
                    <option value="hy">Armenian</option>
                    <option value="ia">Interlingua</option>
                    <option value="ie">Interlingue</option>
                    <option value="ik">Inupiak</option>
                    <option value="in">Indonesian</option>
                    <option value="is">Icelandic</option>
                    <option value="it">Italian</option>
                    <option value="iw">Hebrew</option>
                    <option value="ji">Yiddish</option>
                    <option value="jw">Javanese</option>
                    <option value="ka">Georgian</option>
                    <option value="kk">Kazakh</option>
                    <option value="kl">Greenlandic</option>
                    <option value="km">Cambodian</option>
                    <option value="kn">Kannada</option>
                    <option value="ko">Korean</option>
                    <option value="ks">Kashmiri</option>
                    <option value="ku">Kurdish</option>
                    <option value="ky">Kirghiz</option>
                    <option value="ln">Lingala</option>
                    <option value="lo">Laothian</option>
                    <option value="lt">Lithuanian</option>
                    <option value="lv">Latvian,Lettish</option>
                    <option value="mg">Malagasy</option>
                    <option value="mi">Maori</option>
                    <option value="mk">Macedonian</option>
                    <option value="ml">Malayalam</option>
                    <option value="mn">Mongolian</option>
                    <option value="mo">Moldavian</option>
                    <option value="mr">Marathi</option>
                    <option value="ms">Malay</option>
                    <option value="mt">Maltese</option>
                    <option value="my">Burmese</option>
                    <option value="na">Nauru</option>
                    <option value="ne">Nepali</option>
                    <option value="nl">Dutch</option>
                    <option value="no">Norwegian</option>
                    <option value="oc">Occitan</option>
                    <option value="om">(Afan)Oromo</option>
                    <option value="or">Oriya</option>
                    <option value="pa">Punjabi</option>
                    <option value="pl">Polish</option>
                    <option value="ps">Pashto,Pushto</option>
                    <option value="qu">Quechua</option>
                    <option value="rm">Rhaeto-Romance</option>
                    <option value="rn">Kirundi</option>
                    <option value="ro">Romanian</option>
                    <option value="rw">Kinyarwanda</option>
                    <option value="sa">Sanskrit</option>
                    <option value="sd">Sindhi</option>
                    <option value="sg">Sangro</option>
                    <option value="sh">Serbo-Croatian</option>
                    <option value="si">Singhalese</option>
                    <option value="sk">Slovak</option>
                    <option value="sl">Slovenian</option>
                    <option value="sm">Samoan</option>
                    <option value="sn">Shona</option>
                    <option value="so">Somali</option>
                    <option value="sq">Albanian</option>
                    <option value="sr">Serbian</option>
                    <option value="ss">Siswati</option>
                    <option value="st">Sesotho</option>
                    <option value="su">Sundanese</option>
                    <option value="sv">Swedish</option>
                    <option value="sw">Swahili</option>
                    <option value="ta">Tamil</option>
                    <option value="te">Tegulu</option>
                    <option value="tg">Tajik</option>
                    <option value="th">Thai</option>
                    <option value="ti">Tigrinya</option>
                    <option value="tk">Turkmen</option>
                    <option value="tl">Tagalog</option>
                    <option value="tn">Setswana</option>
                    <option value="to">Tonga</option>
                    <option value="tr">Turkish</option>
                    <option value="ts">Tsonga</option>
                    <option value="tt">Tatar</option>
                    <option value="tw">Twi</option>
                    <option value="uk">Ukrainian</option>
                    <option value="ur">Urdu</option>
                    <option value="uz">Uzbek</option>
                    <option value="vi">Vietnamese</option>
                    <option value="vo">Volapuk</option>
                    <option value="wo">Wolof</option>
                    <option value="xh">Xhosa</option>
                    <option value="yo">Yoruba</option>
                    <option value="zh">Chinese</option>
                    <option value="zu">Zulu</option>
                </select>
            </td>
        </tr>

    </table>
</div>
<div id="tabs-5">
    <table>
        <tr>
            <td class="campo"></td>
            <td class="campo"></td>
        </tr>
        <tr>
            <td class="title">Tamaño</td>


            <td><input type="text" name="lom91technical_size"></td>
        </tr>
        <tr>
            <td class="title">Localización</td>

            <td><input type="text" name="technical_location91location"></td>
        </tr>
        <tr>
            <td class="title">Tipo</td>

            <td><input type="text" name="requirements_orcomposite91type"></td>
        </tr>
        <tr>
            <td class="title">Nombre</td>

            <td><input type="text" name="requirements_orcomposite91name"></td>
        </tr>
        <tr>
            <td class="title">Versión Minima</td>

            <td><input type="text" name="requirements_orcomposite91minimumversion"></td>
        </tr>
        <tr>
            <td class="title">Versión Maxima</td>

            <td><input type="text" name="requirements_orcomposite91maximumversion"></td>
        </tr>
        <tr>
            <td class="title">Pautas de instalación</td>

            <td><input type="text" name="lom91technical_installationremarks"></td>
        </tr>
        <tr>
            <td class="title">Otros qrequisitos de plataforma</td>

            <td><input type="text" name="lom91technical_otherplatformrequirements"></td>
        </tr>
        <tr>
            <td class="title">Duración</td>

            <td><input type="text" name="lom91technical_duration"></td>
        </tr>
    </table>
</div>
<div id="tabs-6">
<table>
<tr>
    <td class="campo"></td>
    <td class="campo"></td>
</tr>
<tr>
    <td class="title">Tipo de interactividad</td>

    <td><input type="text" name="lom91educational_interactivitytype"></td>
</tr>
<tr>
    <td class="title">Tipo de recurso educativo</td>

    <td><input type="text" name="educational_learningresourcetype91learningresourcetype"></td>
</tr>
<tr>
    <td class="title">Nivel de interactividad</td>

    <td><input type="text" name="lom91educational_interactivitylevel"></td>
</tr>
<tr>
    <td class="title">Densidad semántica</td>

    <td><input type="text" name="lom91educational_semanticdensity"></td>
</tr>
<tr>
    <td class="title">Destinatario</td>

    <td><input type="text" name="educational_intendedenduserrole91intendedenduserrole"></td>
</tr>
<tr>
    <td class="title">Contexto</td>

    <td><input type="text" name="educational_context91context"></td>
</tr>
<tr>
    <td class="title">Rango típico de edad</td>

    <td><input type="text" name="educational_typicalagerange91typicalagerange"></td>
</tr>
<tr>
    <td class="title">Dificultad</td>

    <td><input type="text" name="lom91educational_difficulty"></td>
</tr>
<tr>
    <td class="title">Tiempo típico de aprendizaje</td>

    <td><input type="text" name="lom91educational_typicallearningtime"></td>
</tr>
<tr>
    <td class="title">Descripción</td>

    <td><input type="text" name="educational_description91description"></td>
</tr>

<tr>
    <td class="title">Idioma</td>

    <td>     <input type="text" name="educational_language91language" id="educational_language91language">
        <select id="lang">
            <option value="none">Seleccionar</option>
            <option value="es">Spanish</option>
            <option value="en">English</option>
            <option value="pt">Portuguese</option>
            <option value="fr">French</option>
            <option value="ru">Russian</option>
            <option value="ja">Japanese</option>
            <option value="la">Latin</option>
            <option value="aa">Afar</option>
            <option value="ab">Abkhazian</option>
            <option value="af">Afrikaans</option>
            <option value="am">Amharic</option>
            <option value="ar">Arabic</option>
            <option value="as">Assamese</option>
            <option value="ay">Aymara</option>
            <option value="az">Azerbaijani</option>
            <option value="ba">Bashkir</option>
            <option value="be">Byelorussian</option>
            <option value="bg">Bulgarian</option>
            <option value="bh">Bihari</option>
            <option value="bi">Bislama</option>
            <option value="bn">Bengali;Bangla</option>
            <option value="bo">Tibetan</option>
            <option value="br">Breton</option>
            <option value="ca">Catalan</option>
            <option value="co">Corsican</option>
            <option value="cs">Czech</option>
            <option value="cy">Welsh</option>
            <option value="da">Danish</option>
            <option value="de">German</option>
            <option value="dz">Bhutani</option>
            <option value="el">Greek</option>
            <option value="eo">Esperanto</option>
            <option value="et">Estonian</option>
            <option value="eu">Basque</option>
            <option value="fa">Persian</option>
            <option value="fi">Finnish</option>
            <option value="fj">Fiji</option>
            <option value="fo">Faeroese</option>
            <option value="fy">Frisian</option>
            <option value="ga">Irish</option>
            <option value="gd">Scots</option>
            <option value="gl">Galician</option>
            <option value="gn">Guarani</option>
            <option value="gu">Gujarati</option>
            <option value="ha">Hausa</option>
            <option value="hi">Hindi</option>
            <option value="hr">Croatian</option>
            <option value="hu">Hungarian</option>
            <option value="hy">Armenian</option>
            <option value="ia">Interlingua</option>
            <option value="ie">Interlingue</option>
            <option value="ik">Inupiak</option>
            <option value="in">Indonesian</option>
            <option value="is">Icelandic</option>
            <option value="it">Italian</option>
            <option value="iw">Hebrew</option>
            <option value="ji">Yiddish</option>
            <option value="jw">Javanese</option>
            <option value="ka">Georgian</option>
            <option value="kk">Kazakh</option>
            <option value="kl">Greenlandic</option>
            <option value="km">Cambodian</option>
            <option value="kn">Kannada</option>
            <option value="ko">Korean</option>
            <option value="ks">Kashmiri</option>
            <option value="ku">Kurdish</option>
            <option value="ky">Kirghiz</option>
            <option value="ln">Lingala</option>
            <option value="lo">Laothian</option>
            <option value="lt">Lithuanian</option>
            <option value="lv">Latvian,Lettish</option>
            <option value="mg">Malagasy</option>
            <option value="mi">Maori</option>
            <option value="mk">Macedonian</option>
            <option value="ml">Malayalam</option>
            <option value="mn">Mongolian</option>
            <option value="mo">Moldavian</option>
            <option value="mr">Marathi</option>
            <option value="ms">Malay</option>
            <option value="mt">Maltese</option>
            <option value="my">Burmese</option>
            <option value="na">Nauru</option>
            <option value="ne">Nepali</option>
            <option value="nl">Dutch</option>
            <option value="no">Norwegian</option>
            <option value="oc">Occitan</option>
            <option value="om">(Afan)Oromo</option>
            <option value="or">Oriya</option>
            <option value="pa">Punjabi</option>
            <option value="pl">Polish</option>
            <option value="ps">Pashto,Pushto</option>
            <option value="qu">Quechua</option>
            <option value="rm">Rhaeto-Romance</option>
            <option value="rn">Kirundi</option>
            <option value="ro">Romanian</option>
            <option value="rw">Kinyarwanda</option>
            <option value="sa">Sanskrit</option>
            <option value="sd">Sindhi</option>
            <option value="sg">Sangro</option>
            <option value="sh">Serbo-Croatian</option>
            <option value="si">Singhalese</option>
            <option value="sk">Slovak</option>
            <option value="sl">Slovenian</option>
            <option value="sm">Samoan</option>
            <option value="sn">Shona</option>
            <option value="so">Somali</option>
            <option value="sq">Albanian</option>
            <option value="sr">Serbian</option>
            <option value="ss">Siswati</option>
            <option value="st">Sesotho</option>
            <option value="su">Sundanese</option>
            <option value="sv">Swedish</option>
            <option value="sw">Swahili</option>
            <option value="ta">Tamil</option>
            <option value="te">Tegulu</option>
            <option value="tg">Tajik</option>
            <option value="th">Thai</option>
            <option value="ti">Tigrinya</option>
            <option value="tk">Turkmen</option>
            <option value="tl">Tagalog</option>
            <option value="tn">Setswana</option>
            <option value="to">Tonga</option>
            <option value="tr">Turkish</option>
            <option value="ts">Tsonga</option>
            <option value="tt">Tatar</option>
            <option value="tw">Twi</option>
            <option value="uk">Ukrainian</option>
            <option value="ur">Urdu</option>
            <option value="uz">Uzbek</option>
            <option value="vi">Vietnamese</option>
            <option value="vo">Volapuk</option>
            <option value="wo">Wolof</option>
            <option value="xh">Xhosa</option>
            <option value="yo">Yoruba</option>
            <option value="zh">Chinese</option>
            <option value="zu">Zulu</option>
        </select>
    </td>
</tr>

</table>
</div>
<div id="tabs-7">
    <table>
        <tr>
            <td class="campo"></td>
            <td class="campo"></td>
        </tr>
        <tr>
            <td class="title">Coste</td>

            <td><input type="text" name="lom91rights_cost"></td>
        </tr>
        <tr>
            <td class="title">Derechos de autor y otras restricciones</td>

            <td><input type="text" name="lom91rights_copyrightandotherrestrictions"></td>
        </tr>
        <tr>
            <td class="title">Descripción</td>

            <td><input type="text" name="lom91rights_description"></td>
        </tr>
    </table>
</div>
<div id="tabs-8">
    <table>
        <tr>
            <td class="campo"></td>
            <td class="campo"></td>
        </tr>
        <tr>
            <td class="title">Tipo</td>

            <td><input type="text" name="relation_kind"></td>
        </tr>
        <tr>
            <td class="title">Catalogo</td>

            <td><input type="text" name="resource_identifier91catalog"></td>
        </tr>
        <tr>
            <td class="title">Entrada</td>

            <td><input type="text" name="resource_identifier91entry"></td>
        </tr>
        <tr>
            <td class="title">Descripción</td>

            <td><input type="text" name="resource_description91description"></td>
        </tr>

    </table>
</div>
<div id="tabs-9">


    <table>
        <tr>
            <td class="campo"></td>
            <td class="campo"></td>
        </tr>
        <tr>
            <td class="title">Entidad</td>

            <td><input type="text" name="annotation_entity"></td>
        </tr>
        <tr>
            <td class="title">Fecha</td>

            <td><input type="text" name="annotation_date"></td>
        </tr>
        <tr>
            <td class="title">Descripción</td>

            <td><input type="text" name="annotation_description"></td>
        </tr>

    </table>
</div>

<div id="tabs-10">


    <table>
        <tr>
            <td class="campo"></td>
            <td class="campo"></td>
        </tr>
        <tr>
            <td class="title">Propósito</td>

            <td><input type="text" name="lom91classification_purpose"></td>
        </tr>
        <tr>
            <td class="title">Fuente</td>

            <td><input type="text" name="classification_taxonpath91source"></td>
        </tr>
        <tr>
            <td class="title">Entrada</td>

            <td><input type="text" name="taxonpath_taxon91entry"></td>
        </tr>
        <tr>
            <td class="title">Descripción</td>

            <td><input type="text" name="lom91classification_description"></td>
        </tr>
        <tr>
            <td class="title">Palabras Clave</td>

            <td><input type="text" name="classification_keyword91keyword"></td>
        </tr>

    </table>
</div>

</div>
</form>
