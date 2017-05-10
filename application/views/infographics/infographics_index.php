<link type="text/css" rel="stylesheet" href="/modules/map/map.css"/>
<link type="text/css" rel="stylesheet" href="/css/titles.css"/>

<div class="title" id="header"></div>
<div id="map_russia">
    <object type="image/svg+xml" data="/modules/map/russia.svg" onload="svg_ready(this)" id="svg">
    </object>
    <div id="map_title"></div>
</div>
<form name="form1">
    <fieldset id="legend">
        <legend id="legend_header"></legend>
        <ul id="legend_data"></ul>
    </fieldset>
    <fieldset id="rev_type">
        <legend>Выбор субъектов:</legend>
        <label> Федеральные округа<input type="radio" name="filter" value="0" checked="checked"></label>
        <label>Регионы<input type="radio" name="filter" value="1"></label>
    </fieldset>
</form>

<script type="text/javascript">
    var region_data = {
        <?php
        $i=0;
        foreach ($data['statistic'] as $value) {
            if($i!=0) echo ",\n";
            $numReg = $value['Code'];
            $allStud = $value['allst'];
            $badStud = $value['bad'];
            if($numReg<10 && $numReg>0) {
                $numReg = "0".$numReg;
            }
            $percent = null;
            if($badStud == 0 || $allStud == 0) {
                $percent = "0";
            }
            else {
                $percent = ($badStud/$allStud)*100;
            }
            echo "r".$numReg.": ".$percent;
            $i++;
    }
        ?>
    }
</script>

<script src="/modules/map/regions.js"></script>
<script src="/modules/map/map-data.js"></script>
<script src="/modules/map/map.js"></script>