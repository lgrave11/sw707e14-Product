<table style="width:100%;">
    <tr>
		<th style="width:50%;" colspan="2">Leaves At</th>
        
        <th style="width:50%;" colspan="2">Arrives At</th>
    </tr>
    <?php
        foreach ($bicycleData as $bicycle) {
            echo "<tr>";
            echo "<td>".$bicycle->start_time."</td>";
            echo "<td>".$bicycle->start_station."</td>";
            
            echo "<td>".$bicycle->end_time."</td>";
            echo "<td>".$bicycle->end_station."</td>";
            
            echo "</tr>";
        }
    ?>
</table>
