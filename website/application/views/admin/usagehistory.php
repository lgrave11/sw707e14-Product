<div>
    <form>
        <table style="width:100%;">
            <tr>
                <td><h2>Choose Perspective</h2></td>
                <td id="selectlistlabel" style="width:300px;"><h2></h2></td>
                <td><h2>From Time</h2></td>
                <td><h2>To Time</h2></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <select id="usageperspective" onchange="UpdateSelectList()">
                        <option>Traffic</option>
                        <option>Station</option>
                    </select>
                </td>
                <td>
                    <select name="StationBicycleList" style="display: none;">
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
    </form>
    <hr />
    <div>
        <img id="loading" src="/public/images/ajax-loader.gif" alt="loading gif" />
        
        <div id="usagecontent">
            
        </div>
    </div>
</div>
