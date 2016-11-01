<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table class="studentList">
<?php
    print ("<tr><th>Регион \ Направления</th>");
    $firstval =  $data['direction']['0']['Name'];
    $count = 0;
    while ($data['direction'][$count]['Name'] == $firstval){
        printf("<th >%s %s</th>", $data['direction'][$count]['ID_Direction'], $data['direction'][$count]['dirName']);
        $count++;
    }
    print("</tr>");
    for($i=0; $i < count($data['direction']); $i+=$count){
        printf("<tr onclick='document.location.href=\"/university/index/region/%s\"'><td style='text-align: left'>%s</td>",$data['direction'][$i]['ID'] , $data['direction'][$i]['Name']);
        for ($j=0; $j < $count; $j++){
            printf("<td>%s</td>", $data['direction'][$i+$j]['count']);

        }
        print("</tr>");
    }
?>
</table>
