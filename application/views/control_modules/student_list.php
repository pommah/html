<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<?php
    print ("<table class='studentList'>
        <tr>
            <th>Идентификатор</th>
            <th>Нозоологическая группа</th>
            <th>Направление</th>
            <th>Дата обучения</th>
            <th>Программа</th>
        </tr>");
    foreach ($data['students'] as $student){
        print("<tr>");
        printf("<td>%s</td>", $student['Name']);
        printf("<td>%s</td>", $student['NozologyGroup']);
        printf("<td>%s</td>", $student['Direction']);
        printf("<td>%s <b>-</b> %s</td>", str_replace("-",".",$student['DateBegin']), str_replace("-",".",$student['DateEnd']));
        printf("<td>%s</td>", $student['NameFile']);

        print("</tr>");
    }
    print("</table>");
?>
