<html>
<head>
    <title><?php echo $data['user']['title']; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/head.css">

</head>
<body>
<div class="head">
    <div class="logoBlock">
    <img class="logo" src='/images/logo.png'>
        </div>
    <div class="caption">
        Система учета и сопровождения в процессе получения высшего образования лиц с инвалидностью</div>
    <div class="headMenus">
        <div class="itemMenu" onclick="document.location.href='/user/info'">
            <img style="width: 25px" src='/images/user.png'/><?php echo $data['user']['name']; ?>
        </div>
        <div class="itemMenu">
            <img style="height: 25px" src='/images/university.png'/>
            <?php echo $data['user']['title']; ?>
        </div>
        <div class="itemMenu exit" onclick="document.location.href='/user/destroy_session'">
            <img style="height: 25px" src='/images/exit.png'/>Выход
        </div>
    </div>
</div>
<div class="outer">
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
    </div>
</body>
</html>