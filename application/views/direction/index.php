<link rel="stylesheet" type="text/css" href="/css/direction.css">
<?php
foreach ($data['content'] as $key => $value) {
    //echo $key." ".$value['ugsnName'];
    printf("
    <div class='group'>
        <div class='nameUgsn'>%s %s</div>
        <div class='listDirection'>",$key,$value['ugsnName']);
    foreach ($value['listDir'] as $key1 => $value1) {
        printf("
                    <div class='listItem'>
                        <div class='codeDirection'>%s.%s.%s</div>
                        <div class='nameDirection'>%s</div>
                    </div>
                ",substr($key1,0,2),substr($key1,2,2),substr($key1,4,2),$value1);
    }
    printf("</div>
    </div>
    ");
}
?>
