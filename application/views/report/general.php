<link rel="stylesheet" type="text/css" href="/css/report.css">
<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<script type="text/javascript" src="/js/pieHint.js"></script>
<div class="blockReport">
    <div class="headReport">Общая информация о системе</div>
    <div class="item">
        <div class="leftLabel">Кол-во университетов в системе:</div>
        <div class="rightLabel"><?php echo $data['generalInfo'][0]['AllUniversity']; ?></div>
    </div>
    <div class="item">
        <div class="leftLabel">Государственные:</div>
        <div class="rightLabel"><?php echo $data['generalInfo'][0]['PublicUniversity']; ?></div>
    </div>
    <div class="item par">
        <div class="leftLabel">Частные:</div>
        <div class="rightLabel"><?php echo $data['generalInfo'][0]['PrivateUniversity']; ?></div>
    </div>
        <div class="item">
            <div class="leftLabel">Кол-во студентов в системе:</div>
            <div class="rightLabel"><?php echo $data['generalInfo'][0]['CountStudent']; ?></div>
        </div>
    <div class="item">
        <div class="leftLabel">С нарушением зрения:</div>
        <div class="rightLabel"><?php echo $data['generalInfo'][0]['Vision']; ?></div>
    </div>
    <div class="item">
        <div class="leftLabel">С нарушением слуха:</div>
        <div class="rightLabel"><?php echo $data['generalInfo'][0]['Hearing']; ?></div>
    </div>
    <div class="item">
        <div class="leftLabel">С поражением опорно-двигательного аппарата:</div>
        <div class="rightLabel"><?php echo $data['generalInfo'][0]['MusculeSkelete']; ?></div>
    </div>
    <?php echo Controller_Report::draw_pie($data['pie_region'], "  федеральный округ", "Распределение студентов по округам", 'Name', 'count');
    echo Controller_Report::draw_pie($data['pie_nozology'], '', 'Распределение студентов по нозологическим группам', 'Name', 'count');
    echo Controller_Report::draw_pie($data['pie_year'], ' год', 'Распределение студентов по дате поступления', 'Name', 'count');
    echo Controller_Report::draw_pie($data['pie_level'], '', 'Распределение студентов по уровню образования', 'Name', 'count');
    echo Controller_Report::draw_pie($data['pie_form'], ' форма обучения', 'Распределение студентов по форме обучения', 'Name', 'count');?>
</div>