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
        printf("<td><button class='button' onclick='deleteStud(event, this)'>Удалить</button> </td>");
        print("</tr>");
    }
    print("</table>");
?>
<script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="/js/studentList.js"></script>