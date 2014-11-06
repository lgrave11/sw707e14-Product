<table>
    <tr>
        <th>Station</th>
        <th>Leaves At</th>
        <th>Arrives At</th>
    </tr>
    <?php
        foreach ($bicycleData as $bicycle) {
            echo "<tr>";
            
            echo "<td>".$bicycle->station_name."</td>";
            echo "<td>".date("d/m/Y H:i:s", $bicycle->start_time)."</td>";
            echo "<td>".date("d/m/Y H:i:s", $bicycle->end_time)."</td>";
            
            echo "</tr>";
        }
    ?>
</table>
