<script>
    $(document).ready(function(){
        $(".btn2").button();
        $("#tools").hide();
        $("#avan").click(function(){
            $("#avan").hide();
            $("#tools").show();
            $("#simple").hide();
            $("#contenido").empty();
            $("#avanzada").load("<?php echo base_url()?>index.php/busqueda/busqueda_avanzada_form");


        });

        $("#b-s").click(function(){
            $("#avanzada").empty();
            $("#contenido").empty();
            $("#avan").show();
            $("#simple").show();
            $("#tools").hide();
            $("#avan").attr('checked', false);

        });
    });

</script>
<br><br><br><div class="art-post-inner art-article">
    <div><h2 class="art-postheader"  align="center">Buscar en FROAC</h2>

        <div class="art-postcontent">
            <div id="searchContainer">
                <div id="tools">
                    <br><br>
                    <input type="button" name="search" id="submit2" value="Search" />

                    <button id="b-s" class="btn2">Volver a busqueda simple</button>

                </div>
                <h3 align="center">
                    <div id="simple">
                    <form>
                        <input type="text" name="search" id="field" />
                        <input type="submit "name="search" id="submit" value="Search" />

                    </form>
                        </div>
                    </h3>

                <div align="center"><button id="avan" class="btn2">Busqueda Avanzada</button></div>

            </div>
            <div id="avanzada">

            </div>



        </div></div>
    <div class="cleared"></div>
</div>



<div class="cleared"></div>
</div>
</div>

<div class="art-post">
    <div class="art-post-body">