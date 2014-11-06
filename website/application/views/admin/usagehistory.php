<div>
    <form>
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
        </select><br /><br />
        <?php
            require 'application/views/admin/timeintervalpicker.php';
        ?>
        <br /><br />
        <input type="button" onclick="UpdateUsageContent()" value="Get History" />
    </form>
    <hr />
    <div>
        <img id="loading" src="/public/images/ajax-loader.gif" alt="loading gif" />
        
        <div id="usagecontent">
            
        </div>
    </div>
</div>
