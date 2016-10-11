<?php
class Model_User extends Model
{
    public function get_user_data(){
        $userData = [];
        $conn = parent::get_db_connection();
        $query = $conn->prepare("SELECT Name, Login, Email, Permission FROM User WHERE Login = ?");
        $query->bindParam(1, $_SESSION['login']);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_NAMED);
        $userData['login'] = $data['Login'];
        $userData['name'] = $data['Name'];
        $userData['e-mail'] = $data['Email'];
        $userData['permission'] = $data['Permission'];
        return $userData;
    }

    public function update_user_data($dataArray){
        $conn = parent::get_db_connection();
        $query = $conn->prepare("UPDATE User SET Name=?, Email=? WHERE Login=?");
        $query->bindParam(1, $dataArray[0]);
        $query->bindParam(2, $dataArray[1]);
        $query->bindParam(3, $_SESSION['login']);
        $query->execute();
        echo "OK";
    }
}