<link type="text/css" rel="stylesheet" href="/css/pie.css"/>
<script src="/js/pie.js"></script>
<div>
    <h1 id="header"></h1>
    <?php
        $json = json_encode($data['pie_data']);
        printf("<div id=\"pie_canvas\" data='%s'>", $json);
    ?>
        <svg id='svg' width='200' height='200'>
            <g id='map'></g>
        </svg>
        <ul id="map_data"></ul>
        <div id="pie_title"></div>
    </div>
    <form name="form1">
        <fieldset id="legend">
            <legend id="legend_header"></legend>
            <ul id="legend_data"></ul>
        </fieldset>
    </form>
</div>