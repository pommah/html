<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<?php
    print ("<table class='studentList'>
        <tr>
            <th>Идентификатор</th>
            <th>Нозоологическая группа</th>
            <th>Направление</th>
            <th>Программа</th>
            <th></th>
        </tr>");
    foreach ($data['students'] as $student){
        printf("<tr onclick=\"window.location.href = '/student/info/%s'\">", $student['ID']);
        printf("<td>%s</td>", $student['Name']);
        printf("<td>%s</td>", $student['NozologyGroup']);
        printf("<td>%s</td>", $student['Direction']);
        printf("<td><a title='%s' href='%s'><img width='40' src='/images/pdf_file.png'></a></td>", $student['NameFile'],$student['NameFile']);
        printf("<td><img src='/images/delete_file.png' width='18' onclick='deleteStud(event, this)'><img src='/images/edit_file.png' width='18' onclick='event.stopPropagation(); window.location.href=\"/student/edit/%s\"'>
        </td>", $student['ID']);
        print("</tr>");
    }
    print("</table>");
?>
<script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="/js/studentList.js"></script>