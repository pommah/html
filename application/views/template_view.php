<link rel="stylesheet" type="text/css" href="/css/template.css">
<div class="title"><?php echo $data['user']['title']; ?></div>
<div class="mainBlock">
    <div class="menu">
        <?php
        foreach ($data['menus']['list'] as $key => $value) {
            if($data['menus']['selected']==$key) {
                $selected = "selected";
            }
            else $selected = null;
            printf("
                    <a href='/control/%s'><div class=\"item_menu %s\" id=\"%s\">%s</div></a>
            ", $key, $selected, $key, $value);
        }
        ?>
    </div>
    <div class="data_content">
        <?php
            include($content);
        ?>
    </div>
</div>