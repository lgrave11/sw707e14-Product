<div>
    <form action="/Admin/UsageHistoryForm" method="POST">
        <h2>Choose Perspective</h2>
        <select onchange="UpdateSelectList()">
            <option>Bicycle</option>
            <option>Station</option>
        </select>
        <h2>Choose Bicycle</h2>
        <select name="StationBicycleList">
            <?php
                echo ViewHelper::GenerateHTMLSelectOptions($list);
            ?>
        </select><br /><br />
        <input type="submit" value="Get History" />
    </form>
    
    <div>
    <!-- Show stuff! -->
    </div>
</div>
