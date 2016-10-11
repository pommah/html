<?php
class Model_Control extends Model
{

    public function get_data_user() {
        include('modules/db.php');
        $user = [];
        $req = $conn->prepare("SELECT * FROM User WHERE login=? AND password=?");
        $req->bindParam(1, $_SESSION['login']);
        $req->bindParam(2, $_SESSION['password']);
        $req->execute();
        if($req->rowCount()) {
            $row = $req->fetch();
            $user['name'] = $row['Name'];
            $ID_Univer = $row['ID_Univer'];
            $reqUniver = $conn->query("SELECT Name FROM University WHERE ID='$ID_Univer'");
            $univer = $reqUniver->fetch();
            $user['title'] = $univer['Name'];
        }
        else {
            $user['name'] = 'undefined';
        }
        return $user;
    }
    public static function get_menu_university() {
        $menu = [
            "list" => [
                "direction" => "УГСН и направления",
                "students" => "Студенты",
                "add_student" => "Добавить студента",
                "settings" => "Изменение данных университета"
            ],
            "selected" => "direction"
            ];
            return $menu;
    }


}