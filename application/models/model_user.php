<?php
class Model_User extends Model
{
    public function get_user_data($id)
    {
        $userData = [];
        $conn = parent::get_db_connection();
        $query = $conn->prepare("select User.Name, Permission, ifnull(University.FullName, '-') as Univer, University.ID as UniverId, Login, Email 
	from User left join University on User.ID_Univer = University.ID
    where User.ID = ?");
        $query->bindParam(1, $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_NAMED);
    }

    public function add_user($name, $login, $password, $email, $permission, $university = null)
    {
        $conn = parent::get_db_connection();
        $req = $conn->prepare("INSERT INTO User(Name,Permission,ID_Univer,Login,Password,Email) VALUES(?,?,?,?,?,?)");
        $req->bindParam(1, $name);
        $req->bindParam(2, $permission);
        if ($permission == UserTypes::UNIVERSITY) {
            $req->bindParam(3, $university);
        } else {
            $university = null;
            $req->bindParam(3, $university);
        }
        $req->bindParam(4, $login);
        $pass = substr(md5($password . md5($login)), 0, 24);
        $req->bindParam(5, $pass);
        $req->bindParam(6, $email);
        $req->execute();
        if (!$req->errorCode()[0]) {
            return "OK";
        } else return $req->errorInfo()[0];
    }

    public function get_user_data_by_login($login)
    {
        $userData = [];
        $conn = parent::get_db_connection();
        $query = $conn->prepare("select User.Name, Permission, ifnull(University.FullName, '-') as Univer, University.ID as UniverId, Login, Email 
	from User left join University on User.ID_Univer = University.ID
    where User.Login = ?");
        $query->bindParam(1, $login);
        $query->execute();
        return $query->fetch(PDO::FETCH_NAMED);
    }

    public function get_universities()
    {
        $conn = parent::get_db_connection();
        $req = $conn->query("SELECT ID, FullName, ShortName FROM University ORDER BY FullName");
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function update_user_data($dataArray)
    {
        $conn = parent::get_db_connection();
        $newPassword = '';
        $strPass = '';
        if(isset($dataArray[3])) {
            $lastPassword = substr(md5($dataArray[3] . md5($dataArray[2])), 0, 24);
            $checkPass = $conn->prepare("SELECT * FROM User WHERE Login=? AND Password=?");
            $checkPass->bindParam(1, $dataArray[2]);
            $checkPass->bindParam(2, $lastPassword);
            $checkPass->execute();
            if ($checkPass->rowCount()) {
                $newPassword = substr(md5($dataArray[4] . md5($dataArray[2])), 0, 24);
                $strPass = ', Password=?';
            }
            else {
                return "Неверно указан старый пароль";
            }
        }
        $query = $conn->prepare("UPDATE User SET Name=?, Email=?".$strPass." WHERE Login=?");
        $query->bindParam(1, $dataArray[0]);
        $query->bindParam(2, $dataArray[1]);
        $i=0;
        if(!empty($newPassword)) {
            $query->bindParam(3, $newPassword);
            $i=1;
        }
        $query->bindParam((3+$i), $dataArray[2]);
        $query->execute();

        if($newPassword && $dataArray[2]==$_SESSION['login']) {
            $_SESSION['password']=$newPassword;
        }
        if (!$query->errorCode()[0]) {
            return "OK";
        } else return $query->errorInfo()[0];
    }

    public function get_all_users()
    {
        $req = parent::get_db_connection()->query("select User.ID, User.Name, Permission, ifnull(University.FullName, '-') as Univer, Login, Email 
	from User left join University on User.ID_Univer = University.ID");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function delete_user($id)
    {
        $conn = parent::get_db_connection();
        $req = $conn->prepare("DELETE FROM User WHERE ID=?");
        $req->bindParam(1, $id);
        $req->execute();
        if (!$req->errorCode()[0]) {
            return "OK";
        } else return $req->errorInfo()[0];
    }
}