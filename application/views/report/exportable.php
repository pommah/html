<?php
$header = $data['header'];
printf("<div class='title' style='display: inline-block;'>%s</div><table class='studentList'><tr><th></th>", $header);

if (isset($data['ugsns'])){
    $ugsnS = 'all';
    if (isset($data['ugsn'])){
        $ugsnS = $data['ugsn'];
    }

    $districtS = 'all';
    if (isset($data['district'])){
        $districtS = $data['district'];
    }

    printf("<form action='%s' method='post'>
<input style='margin: 5px' class='button control_button ok_button' type='submit' value='Экспорт в LibreOffice'>
<input type='hidden' name='ugsn' value='%s'>
<input type='hidden' name='district' value='%s'></form>", $_SERVER['REQUEST_URI']."/export/libre", $ugsnS, $districtS);
    printf("<form action='%s' method='post'>
<input style='margin: 5px' class='button control_button ok_button' type='submit' value='Экспорт в Excel'>
<input type='hidden' name='ugsn' value='%s'>
<input type='hidden' name='district' value='%s'></form>", $_SERVER['REQUEST_URI']."/export/excel", $ugsnS, $districtS);

    $allDistricts = $districtS == "all"?"selected":"";
    $allUgsn = $ugsnS == "all"?"selected":"";

    printf("<form method='post' action=''><select class='input' style='margin: 5px;' name='ugsn'><option %S value='all'>Все</option>", $allUgsn);
    foreach ($data['ugsns'] as $ugsn){
        $selected = $ugsn['ID'] == $ugsnS?"selected":"";
        printf("<option %s value='%s'>%s %s</option>", $selected, $ugsn['ID'], Utils::dotDirect($ugsn['ID']), $ugsn['Name']);
    }
    printf("</select><select class='input' style='margin: 5px;' name='district'><option %s value='all'>Все</option>", $allDistricts);
    foreach ($data['districts'] as $district){
        $selected = $district['ID'] == $districtS?"selected":"";
        printf("<option %s value='%s'>%s</option>", $selected, $district['ID'], $district['Name']);
    }
    print ("</select><input class='button control_button ok_button' style='margin: 5px;' type='submit' value='Отфильтровать'></form>");
}
else{
    printf("<button style='margin: 10px; width: auto' class='button control_button ok_button' onclick='document.location.href += \"%s\"'><img style='margin-right: 5px;' width='25' src='/images/excel_file.png'/>Экспорт в LibreOffice</button>", "/export/libre");
    printf("<button style='margin: 10px; width: auto' class='button control_button ok_button' onclick='document.location.href += \"%s\"'><img style='margin-right: 5px;' width='25' src='/images/excel_file.png'/>Экспорт в Excel</button>", "/export/excel");
}
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
<link rel="stylesheet" type="text/css" href="/css/tables.css">
<link rel="stylesheet" type="text/css" href="/css/titles.css">
<link rel="stylesheet" type="text/css" href="/css/buttons.css">
<link rel="stylesheet" type="text/css" href="/css/inputs.css">
