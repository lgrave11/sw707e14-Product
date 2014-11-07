<div>
    <form>
        <table style="width:100%;">
            <tr>
                <td><h2>Choose Perspective</h2></td>
                <td id="selectlistlabel" style="width:300px;"><h2>Choose Bicycle</h2></td>
                <td><h2>From Time</h2></td>
                <td><h2>To Time</h2></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <select id="usageperspective" onchange="UpdateSelectList()">
                        <option>Bicycle</option>
                        <option>Station</option>
                    </select>
                </td>
                <td>
                    <select name="StationBicycleList">
                        <?php
                            foreach ($list as $item) {
                                echo ViewHelper::GenerateHTMLSelectOption($item, array('value'=>$item));
                            }
                        ?>
                    </select>
                </td>
                <td>
                    <input id="admin_fromdatepicker" type="text" readonly name="fromdate" value="<?php echo ViewHelper::printDateTime(); ?>" style="width: 100px; text-align: center;" />
                </td>
                <td>
                    <input id="admin_todatepicker" type="text" readonly name="todate" value="<?php echo ViewHelper::printDateTime(); ?>" style="width: 100px; text-align: center;" />
                </td>
                <td>
                    <input type="button" onclick="UpdateUsageContent()" value="Get History" />
                </td>
            </tr>
        </table>
        <!--<div style="float: left; width: 50%; display: inline-block; text-align: center;">
        <h2>Choose Perspective</h2>
        <select id="usageperspective" onchange="UpdateSelectList()">
            <option>Bicycle</option>
            <option>Station</option>
        </select>
        <h2>Choose Bicycle</h2>
        <select name="StationBicycleList">
            <?php
                foreach ($list as $item) {
                    echo ViewHelper::GenerateHTMLSelectOption($item, array('value'=>$item));
                }
            ?>
        </select>
        </div>
        <div style="float: right; width: 50%; display: inline-block; text-align: center;">
        <?php
            require 'application/views/admin/timeintervalpicker.php';
        ?>
        </div>
        <center style="clear: both;">
        <input type="button" onclick="UpdateUsageContent()" value="Get History" />
        </center>-->
    </form>
    <hr />
    <div>
        <img id="loading" src="/public/images/ajax-loader.gif" alt="loading gif" />
        
        <div id="usagecontent">
            
        </div>
    </div>
</div>
