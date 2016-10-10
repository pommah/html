<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<?php
    print ("<table class='studentList'>
        <tr>
            <th>Идентификатор</th>
            <th>Нозоологическая группа</th>
            <th>Направление</th>
            <th>Дата обучения</th>
            <th>Программа</th>
            <th></th>
        </tr>");
    foreach ($data['students'] as $student){
        printf("<tr onclick=\"window.location.href = '/control/students/%s'\">", $student['ID']);
        printf("<td>%s</td>", $student['Name']);
        printf("<td>%s</td>", $student['NozologyGroup']);
        printf("<td>%s</td>", $student['Direction']);
        printf("<td>%s <b>-</b> %s</td>", str_replace("-",".",$student['DateBegin']), str_replace("-",".",$student['DateEnd']));
        printf("<td>%s</td>", $student['NameFile']);
        printf("<td><button class='button' onclick='test(event)'>Удалить</button> </td>");
        print("</tr>");
    }
    print("</table>");
?>
<script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="loadStudent"></script>
