<link type="text/css" rel="stylesheet" href="/modules/map/map.css"/>
<h1 id="header"></h1>
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
<script src="/modules/map/regions.js"></script>
<script src="/modules/map/map-data.js"></script>
<script src="/modules/map/map.js"></script>