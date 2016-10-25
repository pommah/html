<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table id="table" class='studentList'>
    <tr>
        <th>Название ВУЗа</th>
        <th>Число студентов</th>
    </tr>
    <?php
    foreach ($data['universities'] as $university){
        printf("<tr onclick='document.location.href=\"/student/index/%s\"'>", $university['ID']);
        printf("<td>%s</td>", $university['FullName']);
        printf("<td>%s</td></tr>", $university['count']);
    }
    ?>
</table>