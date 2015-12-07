<div class="table_roas">
    
    <table>
        <tr>
            <td>
                Nombre
            </td>
            <td>
                Entidad
            </td>
            <td>
                Fecha de Registro
            </td>
            
            <td>
                Ultima Actualización
            </td>
            <td>
                N° Objetos de Aprendizaje
            </td>
        </tr>
        <?php foreach ($roas as $reposi) { ?>
            <tr>
                <td>
                    <a href="<?php echo $reposi['url'] ?>" target="_blank"><?php echo $reposi['name']; ?></a>
                </td>
                <td>
                    <?php echo $reposi['affiliation']; ?> 
                </td>
                <td>
                    <?php echo $reposi['registrationdate']; ?>
                </td>
                <td>
                    <?php echo $reposi['lastupdate']; ?>
                </td>
                <td>
                    <a href="<?php echo base_url(); ?>oas/oas_repo/<?php echo $reposi['idrepository']; ?>"> 
                    <?php echo $reposi['countoas']; ?></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
