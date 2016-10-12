<link rel="stylesheet" type="text/css" href="/css/student.css">
<link rel="stylesheet" type="text/css" href="/css/prompt.css">
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
    <div class="leftLabel">Уровень образования</div>
    <div class="dataStudent">
        <?php echo $data['student']['Level']; ?>
    </div>
</div>

<div class="info">
    <div class="leftLabel">Форма обучения:</div>
    <div class="dataStudent">
        <?php echo $data['student']['Form']; ?>
    </div>
</div>
<div class="info last">
    <div class="leftLabel">Программа обучения:</div>
    <div class="dataStudent"><a href="<?php echo $data['student']['File']; ?>">Программа обучения</a></div>
</div>

<div class="individualTrack">
    <div class="headTrack">Индивидуальная траектория студента</div>
    <?php
    print("<table id='trackTable' class='trackTable'><tr>");
    for($i=1; $i<=round($data['student']['Period']*2); $i++) {
        if(array_key_exists($i, $data['student']['Track'])) {
            $color = $data['student']['Track'][$i]['Color'];
            $text = null;
            foreach ($data['student']['Track'][$i]['Note'] as $key => $value) {
                $text = $text.' '.$key.'='.$value;
            }
            printf("<td bgcolor='%s' onmouseover=\"prompShow('%s','%s','%s')\">%s</td>",$color, $i, $data['student']['Track'][$i]['Status'],$text, $i);
        }
        else {
            printf("<td>%s</td>", $i);
        }
    }
    print("</tr></table>");
    ?>
    <div class="prompt" id="promt"></div>
</div>
<script type="text/javascript" src="/js/promptShow.js"></script>


