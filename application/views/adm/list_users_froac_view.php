<script src="<?php echo base_url() ?>css/adm/js/smartpaginator.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>css/adm/css/smartpaginator.css" rel="stylesheet" type="text/css" />

<script>
    var searchOnTable = function() {
        var table = $('#mt');
        var value = this.value;
        table.find('tr').each(function(index, row) {
            var allCells = $(row).find('td');
            if (allCells.length > 0) {
                var found = false;
                allCells.each(function(index, td) {
                    var regExp = new RegExp(value, 'i');
                    if (regExp.test($(td).text())) {
                        found = true;
                        return false;
                    }
                });
                if (found == true)
                    $(row).show();
                else
                    $(row).hide();
            }
        });
    };

    $(function() {
        $('#filter').keyup(searchOnTable);
    });
</script>

<script>
    var totalrecord = 40;


    $(document).ready(function() {



        $('ul li').click(function() {

            $('#green-contents').css('display', 'none');

            if ($(this).attr('id') == '1')
                $('#red-contents').css('display', '');
            if ($(this).attr('id') == '2')
                $('#green-contents').css('display', '');
            if ($(this).attr('id') == '3')
                $('#black-contents').css('display', '');
        });
        $('#green').smartpaginator({
            totalrecords: totalrecord,
            recordsperpage: 15,
            datacontainer: 'mt',
            dataelement: 'tr', initval: 0,
            next: 'Next', prev: 'Prev',
            first: 'First',
            last: 'Last',
            theme: 'red'
        });

    });



</script>

<section id="main" class="column">

    <div class="spacer"></div>

    <article class="module width_full">

        <header><h3>Lista de Usuarios Froac</h3></header>
        <div class="module_content">
            <div id="green-contents" class="contents" >
                <label for="filter">Busqueda Usuario</label>
                <input type="text" style="border-radius: 6px; width: 250px;" id="filter"/>
                <br/>
                <br/>

                <table id="mt" cellpadding="0" cellspacing="0" border="0" class="table">
                    <tr class="header">
                    <!--<thead>-->
                    <th>
                        Nombre
                    </th>
                    <th>
                        Apellido
                    </th>
                    <th>
                        Username
                    </th>
                    <th>
                        Rol
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Fecha de registro
                    </th>

                    </tr>
                    <!--</thead>-->
                    <!--<tbody>-->
                        <?php foreach ($usuariosfroac as $key) { ?>
                            <tr>
                                <td width="20%">
                                    <?php echo $key['nombre']; ?>
                                </td>
                                <td width="20%"> 
                                    <?php echo $key['apellido'] ?>
                                </td>                               
                                <td width="15%">
                                    <?php echo $key['username'] ?> 
                                </td>
                                <td width="15%">
                                    <?php echo $key['nombre_rol'] ?> 
                                </td>
                                <td width="15%">
                                    <?php echo $key['email'] ?> 
                                </td>
                                <td width="15%">
                                    <?php echo $key['fecha_registro'] ?> 
                                </td>


                            </tr>
                        <?php } ?>


                    <!--</tbody>-->

                </table>
                <div id="green" style="margin: auto;">
                </div>
            </div>
        </div >


        </div>



        </div>


    </article>
</section>
