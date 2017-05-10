<link rel="stylesheet" type="text/css" href="/css/inputs.css">
<link rel="stylesheet" type="text/css" href="/css/titles.css">
<link rel="stylesheet" type="text/css" href="/css/tables.css">
<link type="text/css" rel="stylesheet" href="/modules/diag/diag.css"/>
<script type="text/javascript" src="/js/pieHint.js"></script>
<div class="blockReport">
    <div class="title">Общая информация о системе</div>
    <div class="item">
        <div class="leftLabel">Кол-во университетов в системе:</div>
        <div class="dataUser rightLabel"><?php echo $data['generalInfo'][0]['AllUniversity']; ?></div>
    </div>
    <div class="item">
        <div class="leftLabel">Государственные:</div>
        <div class="dataUser rightLabel"><?php echo $data['generalInfo'][0]['PublicUniversity']; ?></div>
    </div>
    <div class="item par">
        <div class="leftLabel">Частные:</div>
        <div class="dataUser rightLabel"><?php echo $data['generalInfo'][0]['PrivateUniversity']; ?></div>
    </div>
        <div class="item">
            <div class="leftLabel">Кол-во студентов в системе:</div>
            <div class="dataUser rightLabel"><?php echo $data['generalInfo'][0]['CountStudent']; ?></div>
        </div>
    <div class="item">
        <div class="leftLabel">С нарушением зрения:</div>
        <div class="dataUser rightLabel"><?php echo $data['generalInfo'][0]['Vision']; ?></div>
    </div>
    <div class="item">
        <div class="leftLabel">С нарушением слуха:</div>
        <div class="dataUser rightLabel"><?php echo $data['generalInfo'][0]['Hearing']; ?></div>
    </div>
    <div class="item par">
        <div class="leftLabel">С поражением опорно-двигательного аппарата:</div>
        <div class="dataUser rightLabel"><?php echo $data['generalInfo'][0]['MusculeSkelete']; ?></div>
    </div>
    <?php
    $all = 0;
    $hear = 0;
    $vision = 0;
    $move = 0;
    foreach ($data['diag_prog'] as $key=>$value) {
        $all+=$value[1]+$value[2]+$value[3];
        $vision+=$value[1];
        $hear+=$value[2];
        $move+=$value[3];
    }
    ?>
    <div class="item">
        <div class="leftLabel">Кол-во программ в системе:</div>
        <div class="dataUser rightLabel"><?php echo $all; ?></div>
    </div>
    <div class="item">
        <div class="leftLabel">С нарушением зрения:</div>
        <div class="dataUser rightLabel"><?php echo $vision; ?></div>
    </div>
    <div class="item">
        <div class="leftLabel">С нарушением слуха:</div>
        <div class="dataUser rightLabel"><?php echo $hear; ?></div>
    </div>
    <div class="item">
        <div class="leftLabel">С поражением опорно-двигательного аппарата:</div>
        <div class="dataUser rightLabel"><?php echo $move; ?></div>
    </div>

    <br>
    <div class="title" id="header"></div>
    <br>
    <div id="diag_canvas">
        <svg id="svg" width="500" height="300" onload="diag_load()">
            <g id="map"></g>
        </svg>
        <ul id="map_data"></ul>
    </div>
    <div id="diag_title"></div>
    <form name="form1">
        <fieldset id="legend">
            <legend id="legend_header"></legend>
            <ul id="legend_data"></ul>
        </fieldset>
    </form>

    <?php echo Controller_Report::draw_pie($data['pie_region'], "  федеральный округ", "Распределение студентов по округам", 'Name', 'count');
    echo Controller_Report::draw_pie($data['pie_nozology'], '', 'Распределение студентов по нозологическим группам', 'Name', 'count');
    echo Controller_Report::draw_pie($data['pie_year'], ' год', 'Распределение студентов по дате поступления', 'Name', 'count');
    echo Controller_Report::draw_pie($data['pie_level'], '', 'Распределение студентов по уровню образования', 'Name', 'count');
    echo Controller_Report::draw_pie($data['pie_form'], ' форма обучения', 'Распределение студентов по форме обучения', 'Name', 'count');?>
</div>
<script type="text/javascript">
    <?php
    $max = 0;
        foreach ($data['diag_prog'] as $key=>$value) {
            $temp = $value[1]+$value[2]+$value[3];
            if($temp>$max) $max=$temp;
        }
        $half = $max/6;
        printf("axis_y_h = [%s, %s, %s, %s, %s, %s];",0,$half,$half*2,$half*4,$half*5,$half*6);
    ?>
    var axis_x_data = {
        <?php
        foreach($data['diag_prog'] as $key=>$value) {
            printf("rg%s: [%s, %s, %s],", $key, $value[1], $value[2], $value[3]);
        }

        ?>
    };
    data_title = {
        <?php
        foreach($data['diag_prog'] as $key=>$value) {
            printf("rg%s: \"%sФО\",", $key, $value['Name']);
        }
        ?>
    };
    axis_x_h = [<?php
    foreach($data['diag_prog'] as $key=>$value) {
        printf("\"%sФО\",", preg_replace('/[а-я]/u','', $value['Name']));
    }
    ?>];
</script>
<script src="/modules/diag/diag-data.js"></script>
<script src="/modules/diag/diag.js"></script>