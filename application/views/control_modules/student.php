<link rel="stylesheet" type="text/css" href="/css/student.css">
<div class="info">
    <div class="leftLabel">Идентификатор:</div>
    <div class="dataStudent"><input class="input dataStudent" type="text" value="<?php echo $data['student']['Name']; ?>"></div>
</div>
<div class="info">
    <div class="leftLabel">Нозологическая группа:</div>
    <div class="dataStudent"><input class="input dataStudent" type="text" value="<?php echo $data['student']['Nozology']; ?>"></div>
</div>
<div class="info">
    <div class="leftLabel">Дата начала обучения:</div>
    <div class="dataStudent"><input class="input dataStudent" type="date" value="<?php echo $data['student']['DateBegin']; ?>"></div>
</div>
<div class="info">
    <div class="leftLabel">Дата конца обучения:</div>
    <div class="dataStudent"><input class="input dataStudent" type="date" value="<?php echo $data['student']['DateEnd']; ?>"></div>
</div>
<div class="info">
    <div class="leftLabel">Программа обучения:</div>
    <div class="dataStudent"><?php echo $data['student']['Direction']; ?></div>
</div>
