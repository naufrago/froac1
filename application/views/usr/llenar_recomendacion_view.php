<div class="CSSTableGenerator" >

    <table> 

        <tr>
            <td >Te puede interesar... </td>
        </tr>
        <?php
        for ($j = 0; $j < count($rec); $j++) {
            for ($jj = 0; $jj < count($rec[$j]); $jj++) {
                ?>
                <tr>
                    <td>         <a href="<?php echo $rec[$j][$jj]['location']; ?>"> 
                            <?php echo $rec[$j][$jj]['general_title']; ?> </a> 
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </table>

</div>