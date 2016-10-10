<?php

class model_university_settings extends Model
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
    public function get_menu_university(){
        //return Model_Control::get_menu_university();
    }
    public function get_region_names(){
        include('modules/db.php');
        $req = $conn->prepare("SELECT Name FROM Region");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_COLUMN, 0);
    }
}