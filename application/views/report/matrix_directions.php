<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table class="studentList">
<?php
    printf ("<tr><th>%s</th>", $data["header"]);
    if (isset($data['data']['0'])){
        $firstval =  $data['data']['0']['rowName'];
        $count = 0;
        while ($data['data'][$count]['rowName'] == $firstval){
            printf("<th >%s</th>", $data['data'][$count]['colName']);
            $count++;
        }
        print("</tr>");
        $secondArg = false;
        if (isset($data['data']['0']['arg2'])){
            $secondArg = true;
        }
        for($i=0; $i < count($data['data']); $i+=$count){
            printf("<tr><td style='text-align: left'>%s</td>", $data['data'][$i]['rowName']);
            for ($j=0; $j < $count; $j++){
                $href = $data['to'].'/'.$data['data'][$i+$j]['arg'];
                if ($secondArg){
                    $href.='/'.$data['data'][$i+$j]['arg2'];
                }
                printf("<td onclick='document.location.href=\"%s\"'>%s</td>", $href, $data['data'][$i+$j]['count']);
            }
            print("</tr>");
        }
    }
    else{
        print("</tr><tr><td>Студенты отсутствуют</td></tr>");
    }
?>
</table>
