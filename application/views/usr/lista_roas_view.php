<div class="table_roas">
    
    <table>
        <tr>
            <td>
                Id
            </td>
            <td>
                Nombre
            </td>
            <td>
                Entidad
            </td>
            <td>
                Tipo de Repositorio
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
                    <?php echo $reposi['idrepository']; ?>
                </td>
                <td>
                    <?php echo $reposi['name']; ?>
                </td>
                <td>
                    <?php echo $reposi['affiliation']; ?> 
                </td>
                <td>
                    <?php echo $reposi['typerepository']; ?>
                </td>
                <td>
                    <?php echo $reposi['registrationdate']; ?>
                </td>
                <td>
                    <?php echo $reposi['lastupdate']; ?>
                </td>
                <td>
                    <?php echo $reposi['countoas']; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
