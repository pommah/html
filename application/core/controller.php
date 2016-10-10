<?php
class Controller {
    public $model;
    public $view;
    protected $auth;
    function __construct()
    {
        $this -> view = new View();
    }
    function action_index()
    {
    }
    public function check_auth() {
        session_start();
        if(!isset($_SESSION['login']) || !isset($_SESSION['password'])) {
            $this->auth = null;
        }
        else {
            include_once("modules/db.php");
            $req = $conn->prepare("SELECT * FROM User WHERE login=? AND password=?");
            $req->bindParam(1,$_SESSION['login']);
            $req->bindParam(2,$_SESSION['password']);
            $req->execute();
            if($req->rowCount()) {
                $row = $req->fetch();
                $this->auth = $row['Permission'];
            }
            else {
                $this->auth = null;
                unset($_SESSION['login']);
                unset($_SESSION['password']);
                session_destroy();
            }
        }
    }
    public function destroy_session() {
        session_start();
        unset($_SESSION['login']);
        unset($_SESSION['password']);
        session_destroy();
        header("Location: /");
    }
}
?>