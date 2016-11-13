<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<div id="error"></div>
<link rel="stylesheet" type="text/css" href="/css/tooltip.css">
<?php
    if($data['user']['permission']==UserTypes::MINISTRY) {
        ?>
        <table class='studentList'>
            <tr>
                <th>Идентификатор</th>
                <th>Траектория</th>
            </tr>
            <?php
            foreach ($data['Trajectories'] as $id => $student) {
                printf("<tr onclick='document.location.href=\"/student/info/%s\"'><td>%s</td><td><table>", $id, $student['Name']);
                foreach ($student['Semesters'] as $number => $info) {
                    $message = "Семестр №" . $number . "\n" . $info['Status'] . "\n" . $info['Note'];
                    foreach ($info['Disciplines'] as $discipline) {
                        $message = $message . "\n" . $discipline['Name'] . "\n" . $discipline['Deadline'];
                    }
                    printf("<td style='width: 50px; background-color: %s' class='tooltip'><span class='tooltiptext'>%s</span></td>", $info['Color'], $message);
                }
                print("</table></td></tr>");
            }

            ?>
        </table>
        <?php
    }
    print ("<table id='studentList' class='studentList'>
        <tr>
            <th>Идентификатор</th>
            <th>Нозологическая группа</th>
            <th>Направление</th>
            <th>Программа</th>");
    if($data['user']['permission']==2){
        print ("<th></th>");
    }
    print("</tr>");
    foreach ($data['students'] as $student){
        printf("<tr id='student_%s' onclick=\"window.location.href = '/student/info/%s'\">", $student['ID'], $student['ID']);
        printf("<td>%s</td>", $student['Name']);
        printf("<td>%s</td>", $student['NozologyGroup']);
        printf("<td>%s</td>", $student['Direction']);
        printf("<td><a title='%s' href='files/programs/%s'><img width='40' src='/images/pdf_file.png'></a></td>", $student['NameFileProgram'],$student['NameFileProgram']);
        if($data['user']['permission']==2)
        printf("<td><img src='/images/delete_file.png' width='18' onclick='deleteStud(event, \"%s\")'><img src='/images/edit_file.png' width='18' onclick='event.stopPropagation(); window.location.href=\"/student/edit/%s\"'>
        </td>", $student['ID'], $student['ID']);
        print("</tr>");
    }
    print("</table>");
?>
<script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="/js/deleteStudent.js"></script>