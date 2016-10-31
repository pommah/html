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
                "menu" => Authorized_Controller::get_menu($user['permission'])
            ];
        }else{
            $position = explode('/', $_SERVER['REQUEST_URI']);
            if(!empty($position[1]))
                header("Location: /");
        }
    }

    public function get_user_type(){
        return $this->data['user']['permission'];
    }

    public function get_user_university_id(){
        return $this->data['user']['univerId'];
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
            $reqUniver = Model::get_db_connection()->query("SELECT ID, ShortName, FullName FROM University WHERE ID='$ID_Univer'");
            $univer = $reqUniver->fetch();
            $user['title'] = $univer['ShortName'];
            $user['fullName'] = $univer['FullName'];
            $user['permission'] = $row['Permission'];
            $user['univerId'] = $univer['ID'];
        }
        else {
            $user['name'] = 'undefined';
        }
        return $user;
    }

    public static function get_menu($userType){
        switch ($userType){
            case UserTypes::UNIVERSITY:
                return [
                    [ "href" => "/student", "title" => "Студенты", "submenus" => ["Добавить" => "/student/add"]],
                    [ "href" => "/trajectory", "title" => "Траектории", "submenus" => []],
                    [ "href" => "/direction", "title" => "УГСН и направления", "submenus" => ["Редактировать" => "/direction/edit_all"]],
                    [ "href" => "/university/edit", "title" => "Данные университета", "submenus" => []]
                ];
                break;
            case UserTypes::MINISTRY:
                return [
                    [ "href" => "/university", "title" => "Университеты", "submenus" => []],
                    [ "href" => "/student/search", "title" => "Студенты", "submenus" => []],
                    [ "href" => "/report", "title" => "Отчеты", "submenus" => []],
                    [ "href" => "/report/matrix/nozology", "title" => "Матрицы", "submenus" => ["По нозологической группе" => "/report/matrix/nozology", "По УГСН" => "/report/matrix/ugsn"]],
                    [ "href" => "/infographics", "title" => "Инфографика", "submenus" => []]
                ];
                break;
            case UserTypes::ADMIN:
                return [
                    [ "href" => "/user", "title" => "Пользователи", "submenus" => ["Добавить" => "/user/add"]]
                ];
        }
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