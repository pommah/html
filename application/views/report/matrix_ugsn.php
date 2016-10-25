<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<div class="contentUgsn">
<table class="studentList">
    <tr>
        <th>Регион</th>
        <?php
            foreach ($data['all_ugsn'] as $row){
                printf("<th >%s\n%s</th>", $row['ID'], $row['Name']);
            }
        ?>
    </tr>
    <?php
        $ugsnCount = count($data['all_ugsn']);
        for($i=0; $i < count($data['ugsn']); $i+=$ugsnCount){
            printf("<tr><td>%s</td>", $data['ugsn'][$i]['Name']);
            for ($j=0; $j < $ugsnCount; $j++){
                printf("<td>%s</td>", $data['ugsn'][$i+$j]['count']);
            }
            print("</tr>");
        }
    ?>
</table>
    </div>
