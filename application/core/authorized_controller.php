<?php
class Authorized_Controller extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_auth();
        if($this->auth) {
            $user = $this->get_data_user();
            $this->data = [
                "user" => $user,
                "menu" => Authorized_Controller::get_menu(UserTypes::UNIVERSITY)
            ];
        }else{
            header("Location: /");
        }
    }

    public function get_data_user() {
        $user = [];
        $req = Model::get_db_connection()->prepare("SELECT * FROM User WHERE login=? AND password=?");
        $req->bindParam(1, $_SESSION['login']);
        $req->bindParam(2, $_SESSION['password']);
        $req->execute();
        if($req->rowCount()) {
            $row = $req->fetch();
            $user['name'] = $row['Name'];
            $ID_Univer = $row['ID_Univer'];
            $reqUniver = Model::get_db_connection()->query("SELECT ShortName, FullName FROM University WHERE ID='$ID_Univer'");
            $univer = $reqUniver->fetch();
            $user['title'] = $univer['ShortName'];
            $user['fullName'] = $univer['FullName'];
        }
        else {
            $user['name'] = 'undefined';
        }
        return $user;
    }

    public static function get_menu($userType){
        return [
            [ "href" => "/student", "title" => "Студенты", "submenus" => ["Добавить" => "/student/add"]],
            [ "href" => "/trajectory", "title" => "Траектории", "submenus" => []],
            [ "href" => "/direction", "title" => "УГСН и направления", "submenus" => ["Редактировать" => "/direction/edit_all"]],
            [ "href" => "/university/edit", "title" => "Данные университета", "submenus" => []]
        ];
    }

    public function check_auth() {
        session_start();
        if(!isset($_SESSION['login']) || !isset($_SESSION['password'])) {
            $this->auth = null;
        }
        else {
            $req = Model::get_db_connection()->prepare("SELECT * FROM User WHERE login=? AND password=?");
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
    public function action_destroy_session() {
        session_start();
        unset($_SESSION['login']);
        unset($_SESSION['password']);
        session_destroy();
        header("Location: /");
    }
}