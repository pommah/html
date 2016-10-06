<html>
<head>
    <title>Редактирование ОПОП</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/head.css">
</head>
<body>
<div class="head">
    <div class="type leftMenu">Редактирование списка направлений</div>
    <div class="exit rightMenu" onclick="document.location.href='/control/exit'">Выход</div>
    <div class="nameUser rightMenu"><?php echo $data['user']['name']; ?></div>
</div>

<div class="content">
    <table>
        <?php
        foreach ($data['all_directions'] as $ugsn){
            print ("<tr>");
            printf ("<td colspan='3'>%s</td>", $ugsn['ugsnName']);
            foreach ($ugsn['listDir'] as $dirId => $dirName){
                print ("<tr>");
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
</div>
</body>
<script type="text/javascript" src="/js/directionEditor.js"></script>
</html>