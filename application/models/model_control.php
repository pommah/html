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
    public function get_menu_university() {
        $menu = [
            "list" => [
                "direction" => "УГСН и направления",
                "students" => "Студенты",
                "add_student" => "Добавить студента"
            ],
            "selected" => "direction"
            ];
            return $menu;
    }
    public function get_direction() {
        $dir = [];
        $nowUgsn = null;
        include('modules/db.php');
        $req = $conn->query("SELECT UGSN.ID as ugsnId, UGSN.Name as ugsnName, Direction.ID as dirId, Direction.Name as dirName FROM UGSN INNER JOIN Direction ON UGSN.ID = Direction.ID_Ugsn");
        while ($row = $req->fetch()) {
            if(!$nowUgsn || $nowUgsn!=$row['ugsnId']) {
                $dir[$row['ugsnId']] = [
                    "ugsnName" => $row['ugsnName'],
                    "listDir" => [
                        $row['dirId'] => $row['dirName']
                    ]
                ];
                $nowUgsn = $row['ugsnId'];
            }
            else {
                $dir[$row['ugsnId']]['listDir'][$row['dirId']] = $row['dirName'];
            }
        }
        return $dir;
    }
}