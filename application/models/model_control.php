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
    public function get_university_directions($universityId){
        $dir = [];
        $nowUgsn = null;
        include('modules/db.php');
        $req = $conn->prepare("SELECT UGSN.ID as ugsnId, UGSN.Name AS ugsnName, Direction.ID AS dirId, Direction.Name AS dirName
	FROM (Direction INNER JOIN UniversityDirection ON Direction.ID=UniversityDirection.ID_Direction) INNER JOIN UGSN ON Direction.ID_Ugsn=UGSN.ID
	WHERE UniversityDirection.ID_University=?");
        $req->bindParam(1, $universityId);
        $req->execute();
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
    public function getStudents(){
        $list = [];
        include('modules/db.php');
        $req = $conn->prepare("SELECT Student.ID, Student.Name, NozologyGroup.Name AS \"NozologyGroup\", Direction.Name 
          AS \"Direction\", Student.DateBegin, Student.DateEnd, ProgramStudent.NameFile
	      FROM ((Student INNER JOIN NozologyGroup ON Student.ID_NozologyGroup=NozologyGroup.ID) INNER JOIN 
	      ProgramStudent ON Student.ID_Prog = ProgramStudent.ID) INNER JOIN Direction ON Direction.ID = 
	      ProgramStudent.ID_Direction
          WHERE ProgramStudent.ID_University = ?");
        //Todo Функция получения id университета
        $universityId = 1;
        $req->bindParam(1, $universityId);
        $req->execute();
        $list = $req->fetchAll(PDO::FETCH_NAMED);
        return $list;
    }
    public  function about_student($id = null) {
        include('modules/db.php');
        $student = [];
        $req = $conn->prepare('SELECT Name, (SELECT Name FROM NozologyGroup WHERE ID=ID_NozologyGroup) as Nozology, 
        (SELECT NameFile FROM ProgramStudent WHERE ID=ID_Prog) as Direction, DateBegin, DateEnd
            FROM Student WHERE ID=?');
        $req->bindParam(1,$id);
        $req->execute();
        if($req->rowCount()) {
            while ($row = $req->fetch()) {
                $student = [
                    "Name" => $row['Name'],
                    "Nozology" => $row['Nozology'],
                    "Direction" => $row['Direction'],
                    "DateBegin" => $row['DateBegin'],
                    "DateEnd" => $row['DateEnd']
                ];
            }
        }
        else {
            $student = null;
        }
        return $student;
    }
}