<html>
    <head>
        <title><?php echo $data['user']['title']; ?></title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/head.css">
    </head>
    <body>
    <div class="head">
            <div class="type leftMenu">Управление ВУЗом</div>
        <div class="exit rightMenu" onclick="document.location.href='/control/exit'">Выход</div>
        <div class="nameUser rightMenu"><?php echo $data['user']['name']; ?></div>
    </div>

    <div class="content">
    <?php
    include_once('application/views/template_view.php');
    ?>
        </div>
    </body>
</html>