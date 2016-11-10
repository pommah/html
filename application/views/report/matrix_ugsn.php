<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table class="studentList">
    <?php
        print ("<tr><th>УГСН \ Округ</th>");
        $firstval =  $data['ugsn']['0']['ID'];
        $count = 0;
        while ($data['ugsn'][$count]['ID'] == $firstval){
            printf("<th >%s</th>", $data['ugsn'][$count]['okrug']);
            $count++;
        }
        print("</tr>");
        for($i=0; $i < count($data['ugsn']); $i+=$count){
            printf("<tr><td style='text-align: left'>%s\n%s</td>", Utils::dotDirect($data['ugsn'][$i]['ID']), $data['ugsn'][$i]['Name']);
            for ($j=0; $j < $count; $j++){
                printf("<td onclick='document.location.href = \"/report/matrix/%s/%s/%s\"'>%s</td>", $data['to'], $data['ugsn'][$i+$j]['okrugId'], $data['ugsn'][$i+$j]['ID'], $data['ugsn'][$i+$j]['count']);
            }
            print("</tr>");
        }
    ?>
</table>
