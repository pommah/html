<?php
echo substr(md5("password".md5("admin")),0,24);
?>