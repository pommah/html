<link rel="stylesheet" type="text/css" href="/css/student.css">
<link rel="stylesheet" type="text/css" href="/css/prompt.css">
<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<div class="info">
    <div class="leftLabel">Идентификатор:</div>
    <div class="dataStudent"><?php echo $data['student']['Name']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Нозологическая группа:</div>
    <div class="dataStudent"><?php echo $data['student']['Nozology']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Дата начала обучения:</div>
    <div class="dataStudent"><?php echo $data['student']['DateBegin']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Дата конца обучения:</div>
    <div class="dataStudent"><?php echo $data['student']['DateEnd']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Направление:</div>
    <div class="dataStudent"><?php echo $data['student']['Direction']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Профиль:</div>
    <div class="dataStudent"><?php echo $data['student']['Profile']==''?$data['student']['Direction']:$data['student']['Profile']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Уровень образования</div>
    <div class="dataStudent">
        <?php echo $data['student']['Level']; ?>
    </div>
</div>
<div class="info">
    <div class="leftLabel">Период обучения:</div>
    <div class="dataStudent"><?php echo $data['student']['Period']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Форма обучения:</div>
    <div class="dataStudent">
        <?php echo $data['student']['Form']; ?>
    </div>
</div>
<?php
function print_file_info($file, $description, $folder){
    if ($file != null){
        print("<div class=\"info\">");
        printf("<div class=\"leftLabel\">%s:</div>", $description);
        printf("<div class=\"dataStudent\"><img src='/images/pdf_file.png' width='18'/><a href=\"/files/%s/%s\">%s</a></div>", $folder, $file, $description);
        print ("</div>");
    }
}
print_file_info($data['student']['File'], "Программа обучения", "programs");
print_file_info($data['student']['Plan'], "Учебный план", "plans");
print_file_info($data['student']['Rehabilitation'], "Реабилитационная программа", "rehabilitation");
print_file_info($data['student']['Psychology'], "Психолого-педагогическое сопровождение", "psychology");
print_file_info($data['student']['Career'], "Профориентация", "career");
print_file_info($data['student']['Employment'], "Трудоустройство", "employment");
print_file_info($data['student']['Distance'], "Дистанционные образовательные технологии", "distance");
print_file_info($data['student']['Portfolio'], "Электронное портфолио", "portfolio");
?>
<div class="individualTrack">
    <div class="headTrack">Индивидуальная траектория студента</div>
    <?php
    print("<table id='trackTable' class='trackTable'><tr>");
    for($i=1; $i<=sizeof($data['student']['Track']); $i++) {
        if(array_key_exists($i, $data['student']['Track'])) {
            $color = $data['student']['Track'][$i]['Color'];
            $text = null;
            foreach ($data['student']['Track'][$i]['Note'] as $key => $value) {
                $text = $text.' '.$key.'='.$value;
            }
            printf("<td bgcolor='%s' onmouseover=\"prompShow('%s','%s','%s','%s')\">%s</td>",$color, $i, $data['student']['Track'][$i]['Status'],$text,$data['student']['Track'][$i]['File'], $i);
        }
        else {
            printf("<td>%s</td>", $i);
        }
    }
    print("</tr></table>");
    ?>
    <div class="prompt" id="promt"></div>
    <table class="studentList">
        <tr>
            <th>№ семестра</th>
            <th>Статус</th>
            <th>Примечание</th>
            <th colspan="2">Задолженности</th>
        </tr>
        <?php
        foreach ($data['student']['Track'] as $i => $info){
            $debtCount = sizeof($info['Note']);
            $rowspan = $debtCount > 1 ? $debtCount : 0;
            print("<tr>");
            printf("<td rowspan='%s'>%s</td>", $rowspan, $i);
            printf("<td rowspan='%s'>%s</td>", $rowspan, $info['Status']);
            $file = $info['File'] != null ? $info['File'] : '-';
            if($file!='-') {
                $type = explode(".",$file);
                $im_file = null;
                switch($type[1]) {
                    case "pdf": $im_file="/images/pdf_file.png";
                }
                $file = "<a class='href' href='/orders/" . $file . "'><img width='30' src='".$im_file."'></a>";
            }
            printf("<td rowspan='%s'>%s</td>", $rowspan, $file);
            if ($debtCount == 0){
                print ("<td colspan='2'>-</td>");
            }
            else{
                $count = 0;
                foreach ($info['Note'] as $key => $value) {
                    if ($count == 0){
                        printf("<td>%s</td>", $key);
                        printf("<td>%s</td>", $value);
                    }
                    else{
                        printf("<tr><td>%s</td>", $key);
                        printf("<td>%s</td></tr>", $value);
                    }
                    $count++;
                }
            }
            print("</tr>");
        }
        ?>
    </table>
</div>
<script type="text/javascript" src="/js/promptShow.js"></script>


