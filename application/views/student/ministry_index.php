<link rel="stylesheet" type="text/css" href="/css/tables.css">
<link rel="stylesheet" type="text/css" href="/css/">
<link rel="stylesheet" type="text/css" href="/css/tooltip.css">
<?php
    print ("<table id='studentList' class='studentList'>
            <tr>
                <th>Идентификатор</th>
                <th>Нозологическая группа</th>
                <th>Направление</th>
                <th>Траектория</th>");
    print("</tr>");
    foreach ($data['students'] as $student){
        printf("<tr id='student_%s' onclick=\"window.location.href = '/student/info/%s'\">", $student['ID'], $student['ID']);
        printf("<td>%s</td>", $student['Name']);
        printf("<td>%s</td>", $student['NozologyGroup']);
        printf("<td>%s</td>", $student['Direction']);
        $student = $data['Trajectories'][$student['ID']];
        printf("<td><table>");
        foreach ($student['Semesters'] as $number => $info) {
            $message = "Семестр №" . $number . "\n" . $info['Status'] . "\n" . $info['Note'];
            foreach ($info['Disciplines'] as $discipline) {
                $message = $message . "\n" . $discipline['Name'] . "\n" . $discipline['Deadline'];
            }
            printf("<td style='width: 50px; background-color: %s' class='tooltip'><span class='tooltiptext'>%s</span></td>", $info['Color'], $message);
        }
        print("</table></td></tr>");
    }
    print("</table>");
?>