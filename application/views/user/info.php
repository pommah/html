<link rel="stylesheet" type="text/css" href="/css/student.css">
<div class="info">
    <div class="leftLabel">Логин:</div>
    <div class="dataStudent"><?php echo $data['userData']['login']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Имя:</div>
    <div class="dataStudent"><?php echo $data['userData']['name']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">E-mail:</div>
    <div class="dataStudent"><?php echo $data['userData']['e-mail']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Уровень доступа:</div>
    <div class="dataStudent"><?php echo $data['userData']['permission']; ?></div>
</div>
<button class="button saveButton" onclick="document.location.href='/user/edit'">Изменить</button>