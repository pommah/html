<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table id="table" class='studentList'>
    <tr>
        <th>Регион</th>
        <th>Количество университетов</th>
    </tr>
    <?php
    foreach ($data['regions'] as $region){
        printf("<tr onclick='document.location.href=\"/university/index/region/%s\"'>", $region['ID']);
        printf("<td>%s</td>", $region['Name']);
        printf("<td>%s</td></tr>", $region['count']);
    }
    ?>
</table>