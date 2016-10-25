<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table class="studentList">
    <tr>
        <th>Регион</th>
        <th>Нарушение зрения</th>
        <th>Нарушение слуха</th>
        <th>Поражение опорно-двигательного аппарата</th>
    </tr>
    <?php
        for ($i=0; $i < count($data['nozology']); $i+=3){
            printf("<tr><td>%s</td>", $data['nozology'][$i]['name']);
            printf("<td>%s</td>", $data['nozology'][$i]['count']);
            printf("<td>%s</td>", $data['nozology'][$i+1]['count']);
            printf("<td>%s</td></tr>", $data['nozology'][$i+2]['count']);
        }
    ?>
</table>