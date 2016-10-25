<link rel="stylesheet" type="text/css" href="/css/report.css">
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
</div>