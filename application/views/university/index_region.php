<link rel="stylesheet" type="text/css" href="/css/tables.css">
<link rel="stylesheet" type="text/css" href="/css/titles.css">
<div class="title">Статистика по ВУЗам</div><br>
<table id="table" class='studentList'>
    <tr>
        <th>Название ВУЗа</th>
        <th>Число студентов</th>
        <th>Количество программ</th>
        <?php
            if($data['user']['permission']==UserTypes::ADMIN) print ("<th></th>");
        ?>
    </tr>
    <?php
    if (!empty($data['universities']['0']['ID'])){
        foreach ($data['universities'] as $university){
            printf("<tr onclick='document.location.href=\"/student/index/%s\"'>", $university['ID']);
            printf("<td>%s</td>", $university['FullName']);
            printf("<td>%s</td>", $university['Students']);
            printf("<td>%s</td>", $university['Programs']);
            if($data['user']['permission']==UserTypes::ADMIN)
                printf("<td><img width='30' onclick='delUniver(event,%s)' src='/images/delete_file.png'></td>",$university['ID']);
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
<script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="/js/pieHint.js"></script>