<?php
$header = $data['header'];
printf("<h2 style='display: inline-block;'>%s</h2><table class='studentList'><tr><th></th>", $header);
printf("<button style='margin: 10px;' class='button add_student' onclick='document.location.href += \"%s\"'><img style='margin-right: 5px;' width='25' src='/images/excel_file.png'/>Экспорт в LibreOffice</button>", "/export/libre");
printf("<button style='margin: 10px;' class='button add_student' onclick='document.location.href += \"%s\"'><img style='margin-right: 5px;' width='25' src='/images/excel_file.png'/>Экспорт в Excel</button>", "/export/excel");
printf("<form action='report/region_direction_filter'><input name='test' type='text'><input type='submit' value='Отфильтровать'></form>");
$info = $data['values'];

$firstval =  $info['0']['rowName'];
$count = 0;
while ($info[$count]['rowName'] == $firstval){
    printf("<th >%s</th>", $info[$count]['colName']);
    $count++;
}
print ("<th>Всего</th></tr>");
$overall = [];
for ($i=0; $i<$count; $i++){
    $overall[$i] = 0;
}
for($i=0; $i < count($info); $i+=$count){
    printf("<tr><td style='text-align: left;'>%s</td>", $info[$i]['rowName']);
    $sum = 0;
    for ($j=0; $j < $count; $j++){
        printf("<td style='text-align: right;'>%s</td>", $info[$i+$j]['value']);
        $overall[$j] += $info[$i+$j]['value'];
        $sum += $info[$i+$j]['value'];
    }
    printf("<td>%s</td>", $sum);
    print("</tr>");
}
print("<tr><td style='text-align: left;'>Всего</td>");
for ($i=0; $i<$count; $i++){
    printf("<td style='text-align: right;'>%s</td>", $overall[$i]);
}
printf ("<td>%s</td></tr>", array_sum($overall));
print ("</table>");
?>
<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<link rel="stylesheet" type="text/css" href="/css/add_student.css">
