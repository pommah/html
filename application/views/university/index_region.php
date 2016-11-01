<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table id="table" class='studentList'>
    <tr>
        <th>Название ВУЗа</th>
        <th>Число студентов</th>
        <th>Количество программ</th>
    </tr>
    <?php
    if (!empty($data['universities']['0']['ID'])){
        foreach ($data['universities'] as $university){
            printf("<tr onclick='document.location.href=\"/student/index/%s\"'>", $university['ID']);
            printf("<td>%s</td>", $university['FullName']);
            printf("<td>%s</td>", $university['Students']);
            printf("<td>%s</td>", $university['Programs']);
            print ("</tr>");
        }
    }
    else{
        print ("<tr><td colspan='3'>Университеты, обучающие лиц с инвалидностью, не найдены</td></tr>");
    }
    ?>
</table>
<?php
if (!empty($data['universities']['0']['ID'])){
    echo Controller_Report::draw_pie($data['universities'], "", "Распределение студентов по университетам", 'FullName', 'Students');
    echo Controller_Report::draw_pie($data['universities'], "", "Распределение программ по университетам", 'FullName', 'Programs');
}?>
<script type="text/javascript" src="/js/pieHint.js"></script>