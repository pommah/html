<?php

// OlFile 1.0
//$olFile = new OlFile(nameFile,pathFile);
//nameFile - имя отдаваемого пользователю файла или сохраняемого на сервер, если пусто то имя сгенерируется
//pathFile - папка, куда необходимо сохранить файл, указывать без "/" в начале
//$olFile->saveFile($file) - сохраняет файл на сервере
//$file - файл в base64
//$olFile->createAndUpload($text) - выдает пользователю файл с содержанием $text

Class OlFile {
    protected $pathFile;
    protected $nameFile;
    public function __construct($name = null,$path=null)
    {
        $this->pathFile = $path;
        if(!$name) {
            $this->nameFile = time();
            $this->nameFile = md5($this->nameFile.rand(0,30).rand(0,30));
            $this->nameFile = substr($this->nameFile,0,10);
        }
        else {
            $this->nameFile = $name;
        }
    }

    public function saveFile($file/*base64*/) {
        $newfile = explode(",",$file);
        $decode = str_replace(' ','+',$newfile[1]);
        $type = explode("/",$newfile[0]);
        $type = explode(";",$type[1]);
        switch ($type[0]) {
            case "pdf": $this->nameFile = $this->nameFile.".pdf"; break;
            default: return false;
        }
        $endFile = base64_decode($decode);
        file_put_contents($this->pathFile."/".$this->nameFile, $endFile);
        return $this->nameFile;
    }

    public function createAndUpload($text) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$this->nameFile.'"');
        echo $text;
    }
}
?>