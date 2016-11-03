<?php
class Model_User extends Model
{
    public function get_user_data($id){
        $userData = [];
        $conn = parent::get_db_connection();
        $query = $conn->prepare("select User.Name, Permission, ifnull(University.FullName, '-') as Univer, University.ID as UniverId, Login, Email 
	from User left join University on User.ID_Univer = University.ID
    where User.ID = ?");
        $query->bindParam(1, $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_NAMED);
    }

    public function get_universitys() {
        $conn = parent::get_db_connection();
        $req = $conn->query("SELECT ID, FullName, ShortName FROM University ORDER BY FullName");
        return $req->fetchAll(PDO::FETCH_NAMED);
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

    public function get_all_users(){
        $req = parent::get_db_connection()->query("select User.ID, User.Name, Permission, ifnull(University.FullName, '-') as Univer, Login, Email 
	from User left join University on User.ID_Univer = University.ID");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }
}