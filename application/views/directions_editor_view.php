<html>
<head>
    <title>Редактирование ОПОП</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/head.css">
    <link rel="stylesheet" type="text/css" href="/css/directions_editor.css">
</head>
<body>
<div class="head">
    <div class="type leftMenu">Редактирование списка направлений</div>
    <div class="exit rightMenu" onclick="document.location.href='/control/exit'">Выход</div>
    <div class="nameUser rightMenu"><?php echo $data['user']['name']; ?></div>
</div>

<div class="content">
    <div class="center">
        <table class="directionsEditor">
            <?php
            foreach ($data['all_directions'] as $ugsn){
                print ("<tr>");
                printf ("<td colspan='3'>%s</td>", $ugsn['ugsnName']);
                foreach ($ugsn['listDir'] as $dirId => $dirName){
                    printf ("<tr onclick='toogleCheckbox(event)'>");
                    $checked = in_array($dirId, $data['directions'])?"checked":"";
                    printf("<td><input id='%s' type='checkbox' %s></td>", $dirId, $checked);
                    printf("<td>%s</td>", $dirId);
                    printf("<td>%s</td>", $dirName);
                    print ("</tr>");
                }
                print ("</tr>");
            }
            ?>
        </table>
        <div class="buttonHolder">
            <button class="button directionsEditor" onclick="saveChanges()">Сохранить</button>
            <button class="button directionsEditor" onclick="cancelChanges()">Отменить</button>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="/js/directionEditor.js"></script>
<script type="text/javascript" src="/js/ajax.js"></script>
</html>