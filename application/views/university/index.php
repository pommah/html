<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table class='studentList'>
    <tr>
        <th>Название</th>
        <th>Регион</th>
        <th>Число студентов</th>
    </tr>
    <?php
    foreach ($data['universities'] as $university){
        printf("<td>%s</td>", $university['FullName']);
        printf("<td>%s</td>", $university['Name']);
        printf("<td>%s</td>", $university['count']);
    }
    ?>
</table>

