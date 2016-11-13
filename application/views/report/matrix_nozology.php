<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table class="studentList">
    <tr>
        <th><?php echo $data['colName']; ?></th>
        <th>Нарушение зрения</th>
        <th>Нарушение слуха</th>
        <th>Поражение опорно-двигательного аппарата</th>
    </tr>
    <?php
        if (count($data['nozology']) == 0){
            print ("<tr><td colspan='4'>Студенты не найдены</td></tr>");
        }
        else {
            for ($i=0; $i < count($data['nozology']); $i+=3){
                printf("<tr onclick='document.location.href=\"%s/%s\"'><td>%s</td>", $data['to'], $data['nozology'][$i]['id'], $data['nozology'][$i]['name']);
                printf("<td>%s</td>", $data['nozology'][$i]['count']);
                printf("<td>%s</td>", $data['nozology'][$i+1]['count']);
                printf("<td>%s</td></tr>", $data['nozology'][$i+2]['count']);
            }
        }

    ?>
</table>