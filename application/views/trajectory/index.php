<table class='studentList'>
    <tr>
        <th>Идентификатор</th>
        <th>Траетория</th>
    </tr>
    <?php
        foreach ($data['Trajectories'] as $student){
            printf("<tr><td>%s</td><td><table>", $student['Name']);
            foreach ($student['Semesters'] as $number => $info){
                $message = "Модуль №".$number."\n".$info['Status']."\n".$info['Note'];
                foreach ($info['Disciplines'] as $discipline){
                    $message = $message."\n".$discipline['Name']."\n".$discipline['Deadline'];
                }
                printf("<td style='width: 50px; background-color: %s' class='tooltip'><span class='tooltiptext'>%s</span></td>",$info['Color'], $message);
            }
            print("</table></td></tr>");
        }
    ?>
</table>
<link rel="stylesheet" type="text/css" href="/css/tooltip.css">
<link rel="stylesheet" type="text/css" href="/css/student_list.css">