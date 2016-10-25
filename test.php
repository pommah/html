<?php
include_once "application/core/OlFile.php";
$olFile = new OlFile("text.txt");
$olFile->createAndUpload("keklool");
?>