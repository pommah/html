<?php
class Model_Student extends Model
{
    public function getStudents(){
        $list = [];
        $req = parent::get_db_connection()->prepare("SELECT Student.ID, Student.Name, NozologyGroup.Name AS \"NozologyGroup\" , Direction.Name 
          AS \"Direction\", ProgramStudent.NameFileProgram
	      FROM (((Student INNER JOIN NozologyGroup ON Student.ID_NozologyGroup=NozologyGroup.ID) INNER JOIN 
	      LearningStudent ON LearningStudent.ID_Student=Student.ID ) INNER JOIN ProgramStudent ON ProgramStudent.ID =
	      LearningStudent.ID_Program) INNER JOIN Direction ON Direction.ID = ProgramStudent.ID_Direction
          WHERE ProgramStudent.ID_University = ?");
        //Todo Функция получения id университета
        $universityId = 1;
        $req->bindParam(1, $universityId);
        $req->execute();
        $list = $req->fetchAll(PDO::FETCH_NAMED);
        return $list;
    }
    public  function about_student($id = null) {
        $student = [];
        $conn = parent::get_db_connection();
        $req = $conn->prepare("SELECT Student.ID, Student.Name, NozologyGroup.Name AS \"NozologyGroup\" , Direction.Name 
          AS \"Direction\", ProgramStudent.PeriodOfStudy, ProgramStudent.NameFileProgram, LearningStudent.ID AS LearnID, LearningStudent.DateBegin, LearningStudent.DateEnd, ProgramStudent.Level,
          ProgramStudent.Form
	      FROM (((Student INNER JOIN NozologyGroup ON Student.ID_NozologyGroup=NozologyGroup.ID) INNER JOIN 
	      LearningStudent ON LearningStudent.ID_Student=Student.ID ) INNER JOIN ProgramStudent ON ProgramStudent.ID =
	      LearningStudent.ID_Program) INNER JOIN Direction ON Direction.ID = ProgramStudent.ID_Direction
          WHERE Student.ID = ?");
        $req->bindParam(1,$id);
        $req->execute();
        if($req->rowCount()) {
            while ($row = $req->fetch()) {
                $LearnID = $row['LearnID'];
                $student = [
                    "Name" => $row['Name'],
                    "Nozology" => $row['NozologyGroup'],
                    "Direction" => $row['Direction'],
                    "DateBegin" => $row['DateBegin'],
                    "DateEnd" => $row['DateEnd'],
                    "Level" => $row['Level'],
                    "Form" => $row['Form'],
                    "File" => $row['NameFileProgram'],
                    "Period" => $row['PeriodOfStudy']
                ];
            }
            $reqTrack = $conn->query("SELECT * FROM Trajectory WHERE ID_Learning = '$LearnID'");
            $student['Track'] = [];
            if($reqTrack->rowCount()) {
                while ($row = $reqTrack->fetch()) {
                    $note = [];
                    switch ($row['Status']) {
                        case 'Активен': $color = '#ccccb3'; break;
                        case 'Закончен': $color = '#66ff66'; break;
                        case 'Задолженность': $color = '#ffff33';
                                              $idSem = $row['ID'];
                            $reqDebt = $conn->query("SELECT * FROM BacklogDiscipline WHERE ID_Semester='$idSem'");
                            while($row1 = $reqDebt->fetch()) {
                                $note[$row1['Name']] = $row1['Deadline'];
                            }
                            break;
                    }
                    $student['Track'][$row['NumberSemester']] = [
                        "Status" => $row['Status'],
                        "Note" => $note,
                        "Color" => $color,
                        "File" => $row['Note']
                    ];
                }
            }
        }
        else {
            $student = null;
        }
        return $student;
    }

    public function get_direction() {
        $dir = [];
        $nowUgsn = null;
        $req = parent::get_db_connection()->query("SELECT UGSN.ID as ugsnId, UGSN.Name as ugsnName, Direction.ID as dirId, Direction.Name as dirName FROM UGSN INNER JOIN Direction ON UGSN.ID = Direction.ID_Ugsn");
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

    public function get_nozoology_groups(){
        $req = parent::get_db_connection()->query("SELECT * FROM NozologyGroup");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_programs(){
        $req = parent::get_db_connection()->prepare("SELECT ProgramStudent.ID, ID_Direction, Level, PeriodOfStudy, Form, NozologyGroup.Name FROM ProgramStudent INNER JOIN NozologyGroup ON ID_NozologyGroup=NozologyGroup.ID WHERE ID_University=?");
        $universityId = 1;
        $req->bindParam(1, $universityId);
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_NAMED);
        $programs = [];
        foreach ($data as $row){
            $direction = $row['ID_Direction'];
            $level = $row['Level'];
            $period = $row['PeriodOfStudy'];
            $form = $row['Form'];
            $nozoology = $row['Name'];
            $description = sprintf("%s, %s, %d года, %s форма, %s", $direction, $level, $period, $form, $nozoology);
            $programs[$row['ID']] = $description;
        }
        return $programs;
    }

    public function add_student_to_programm($name, $nozoologyGroupId, $beginDate, $endDate, $programId, $echo = true){
        $conn = parent::get_db_connection();
        $add = $conn->prepare("CALL addStudent(?, ?, ?, ?, ?)");
        $add->bindParam(1, $name);
        $add->bindParam(2, $nozoologyGroupId);
        $add->bindParam(3, $beginDate);
        $add->bindParam(4, $endDate);
        $add->bindParam(5, $programId);
        $add->execute();
        $response = $add->fetchAll(PDO::FETCH_NUM);
        if (empty($response)){
            if ($echo){
                echo "OK";
            }
            else{
                return true;
            }
        }
        else{
            if ($echo){
                echo $response[0][0];
            }
            else {
                return false;
            }
        }
    }

    public function add_student_and_program($name, $nozoologyGroupId, $beginDate, $endDate, $directionId, $level, $studyPeriod, $universityId, $form, $programFileName){
        $conn = parent::get_db_connection();
        $insertProgram = $conn->prepare("INSERT INTO ProgramStudent (ID_Direction, Level, PeriodOfStudy, ID_NozologyGroup, ID_University, Form, NameFileProgram) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertProgram->bindParam(1, $directionId);
        $insertProgram->bindParam(2, $level);
        $insertProgram->bindParam(3, $studyPeriod);
        $insertProgram->bindParam(4, $nozoologyGroupId);
        $insertProgram->bindParam(5, $universityId);
        $insertProgram->bindParam(6, $form);
        $insertProgram->bindParam(7, $programFileName);
        $insertProgram->execute();
        $this->add_student_to_programm($name, $nozoologyGroupId, $beginDate, $endDate, $conn->lastInsertId(), false);
        echo "OK";
    }

    public function delete_student($id) {
        $conn = parent::get_db_connection();
        $delete = $conn->prepare("DELETE FROM Student WHERE ID=?");
        $delete->bindParam(1, $id);
        $delete->execute();
        if($delete->errorCode()[0]) {
            return $delete->errorCode()[0]." ".$delete->errorInfo()[0];
        }
        else {
            return "OK";
        }
    }

}