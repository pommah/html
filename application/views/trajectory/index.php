<table class='studentList'>
    <tr>
        <th>Идентификатор</th>
        <th>Траектория</th>
    </tr>
    <?php
        foreach ($data['Trajectories'] as $id => $student){
            printf("<tr onclick='document.location.href=\"/student/info/%s\"'><td>%s</td><td><table style='margin: 7px;'>", $id, $student['Name']);
            foreach ($student['Semesters'] as $number => $info){
                $message = "Модуль №".$number."\n".$info['Status']."\n".$info['Note'];
                foreach ($info['Disciplines'] as $discipline){
                    $message = $message."\n".$discipline['Name']."\n".$discipline['Deadline'];
                }
                printf("<td style='width: 50px; height: 10px; background-color: %s' class='tooltip'><span class='tooltiptext'>%s</span></td>",$info['Color'], $message);
            }
            print("</table></td></tr>");
        }
    ?>
</table>
<link rel="stylesheet" type="text/css" href="/css/tooltip.css">
<link rel="stylesheet" type="text/css" href="/css/tables.css">