<div id="da-content-area">
    <div class="da-panel-widget">
        <div class="grid_d">
            <h1>Ventas Por Asesores</h1>
            <div class="datagrid">

                <table  id="listacliente">
                    <thead>
                        <tr>
                            <th colspan="6">Mostrar Ventas Por Proyecto

                                <select id="asesores">
                                    <option value="0">--Seleccione El Proyecto--</option>
                                    <?php foreach ($asesores as $key) { ?>

                                        <option value="<?php echo $key["ase_cedula"]; ?>"><?php echo $key["ase_nombre"] . " " . $key["ase_apellido"]; ?></option>
                                    <?php } ?>

                                </select>
                                <input type="submit" value="Buscar Ventas del Asesor" id="search_ficha" />

                            </th>
                        </tr>                        
                </table>               

                <div style=" display: none; "title="Ventas Mes Actual" id="ventas_mes_3_meses"></div>

                <div style="display: none; " title="Ventas Mes Pasado" id="ventas_mes_todos"></div>

            </div>


        </div>
    </div>
</div>

