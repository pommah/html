<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table id="table" class='studentList'>
    <tr>
        <th>Регион</th>
        <th>Количество университетов</th>
        <th>Количество программ</th>
        <th>Количество студентов</th>
    </tr>
    <?php
    foreach ($data['regions'] as $region){
        printf("<tr onclick='document.location.href=\"/university/index/region/%s\"'>", $region['ID']);
        printf("<td>%s</td>", $region['Name']);
        printf("<td>%s</td>", $region['Univers']);
        printf("<td>%s</td>", $region['Programs']);
        printf("<td>%s</td>", $region['Students']);
        print ("</tr>");
    }
    ?>
</table>
<?php echo Controller_Report::draw_pie($data['regions'], "", "Распределение студентов по регионам", 'Name', 'Students');
echo Controller_Report::draw_pie($data['regions'], "", "Распределение программ по регионам", 'Name', 'Programs');?>
<script type="text/javascript" src="/js/pieHint.js"></script>