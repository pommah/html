<link rel="stylesheet" type="text/css" href="/css/tables.css">
<link rel="stylesheet" type="text/css" href="/css/titles.css">
<div class="title">Статистика по округам</div><br>
<table id="table" class='studentList'>
    <tr>
        <th>Округ</th>
        <th>Число регионов</th>
        <th>Количество программ</th>
        <th>Количество студентов</th>
    </tr>
    <?php
    foreach ($data['districts'] as $district){
        printf("<tr onclick='document.location.href=\"/university/index/district/%s\"'>", $district['ID']);
        printf("<td>%s</td>", $district['Name']);
        printf("<td>%s</td>", $district['Regions']);
        printf("<td>%s</td>", $district['Programs']);
        printf("<td>%s</td>", $district['Students']);
        print ("</tr>");
    }
    ?>
</table>
<?php echo Controller_Report::draw_pie($data['districts'], "  федеральный округ", "Распределение студентов по округам", 'Name', 'Students');
echo Controller_Report::draw_pie($data['districts'], "  федеральный округ", "Распределение программ по округам", 'Name', 'Programs');?>
<script type="text/javascript" src="/js/pieHint.js"></script>

