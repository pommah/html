<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table id="table" class='studentList'>
    <tr>
        <th>Округ</th>
        <th>Число регионов</th>
    </tr>
    <?php
    foreach ($data['districts'] as $district){
        printf("<tr onclick='document.location.href=\"/university/index/district/%s\"'>", $district['ID']);
        printf("<td>%s</td>", $district['Name']);
        printf("<td>%s</td></tr>", $district['count']);
    }
    ?>
</table>

