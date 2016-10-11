<html>
<head>
    <title><?php echo $data['user']['title']; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/head.css">
</head>
<body>
<div class="head">
    <div class="type leftMenu"><?php echo $data['user']['fullName'];?></div>
    <div class="exit rightMenu" onclick="document.location.href='/control/exit'">Выход</div>
    <div class="nameUser rightMenu"><?php echo $data['user']['name']; ?></div>
</div>
<div class="userMenu">
    <?php
        foreach ($data['menu'] as $entry){
            printf("<a href='%s'>%s</a>", $entry['href'], $entry['title']);
            foreach ($entry['submenus'] as $name => $href){
                printf("<a href='%s' class='submenu'>%s</a>", $href, $name);
            }
        }
    ?>
</div>
<div class="content">
    <div class="data_content">
        <?php
            include($content);
        ?>
    </div>
</div>
</body>
</html>