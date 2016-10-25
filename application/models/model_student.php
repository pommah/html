<?php
class Model_Student extends Model
{
    public function getStudents($universityId = 1){
        $req = parent::get_db_connection()->prepare("SELECT Student.ID, Student.Name, NozologyGroup.Name AS \"NozologyGroup\" , Direction.Name 
          AS \"Direction\", ProgramStudent.NameFileProgram
	      FROM (((Student INNER JOIN NozologyGroup ON Student.ID_NozologyGroup=NozologyGroup.ID) INNER JOIN 
	      LearningStudent ON LearningStudent.ID_Student=Student.ID ) INNER JOIN ProgramStudent ON ProgramStudent.ID =
	      LearningStudent.ID_Program) INNER JOIN Direction ON Direction.ID = ProgramStudent.ID_Direction
          WHERE ProgramStudent.ID_University = ? AND Status=\"Активно\"");
        $req->bindParam(1, $universityId);
        $req->execute();
        //$list = $req->fetchAll(PDO::FETCH_NAMED);
        return $req->fetchAll(PDO::FETCH_NAMED);
    }
    public  function about_student($id = null) {
        $student = [];
        $conn = parent::get_db_connection();
        $req = $conn->prepare("SELECT Student.ID, Student.Name, NozologyGroup.Name AS \"NozologyGroup\" , Direction.Name 
          AS \"Direction\", ProgramStudent.PeriodOfStudy, ProgramStudent.NameFileProgram, LearningStudent.ID AS LearnID, LearningStudent.DateBegin, LearningStudent.DateEnd, ProgramStudent.Level,
          ProgramStudent.Form, Profile, NameFilePlan, NameFileReabilitProgram, ProgramStudent.ID AS progId
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
                    "Period" => $row['PeriodOfStudy'],
                    "Profile" => $row['Profile'],
                    "Plan" => $row['NameFilePlan'],
                    "Rehabilitation" => $row['NameFileReabilitProgram'],
                    "ProgramId" => $row['progId'],
                    "Period" => $row['PeriodOfStudy'],
                    "LearnID" => $row['LearnID']
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
                        "ID" => $row['ID'],
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

    public function add_student_to_programm($name, $nozoologyGroupId, $beginDate, $endDate, $programId){
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
                echo "OK";
        }
        else{
            echo $response[0][0];
        }
    }

    public function add_student_and_program($name, $nozoologyGroupId, $beginDate, $endDate, $directionId, $profile, $level, $studyPeriod, $form, $programFile, $planFile, $reabilityFile, $universityId){
        $conn = parent::get_db_connection();
        $add = $conn->prepare("CALL addStudentAndProgram(?,?,?,?,?,  ?,?,?,?,?,  ?,?,?)");
        $add->bindParam(1, $name);
        $add->bindParam(2, $nozoologyGroupId);
        $add->bindParam(3, $beginDate);
        $add->bindParam(4, $endDate);
        $add->bindParam(5, $directionId);
        $add->bindParam(6, $profile);
        $add->bindParam(7, $level);
        $add->bindParam(8, $studyPeriod);
        $add->bindParam(9, $form);
        $add->bindParam(10, $programFile);
        $add->bindParam(11, $planFile);
        $add->bindParam(12, $reabilityFile);
        $add->bindParam(13, $universityId);
        $add->execute();
        $response = $add->fetchAll(PDO::FETCH_NUM);
        if (empty($response)){
            echo "OK";
        }
        else{
            echo $response[0][0];
        }
    }

    public function edit_student_add_new_program($studentId, $name, $nozology, $dateBegin, $dateEnd, $direction, $profile, $level, $period, $form, $fProgram, $fPlan, $fRehabilitation, $universityId, $reason){
        $conn = parent::get_db_connection();
        $add = $conn->prepare("CALL addNewProgram(?,?,?,?,?,  ?,?,?,?,?,  ?,?,?,?,?)");
        $add->bindParam(1,$direction);
        $add->bindParam(2,$profile);
        $add->bindParam(3,$level);
        $add->bindParam(4,$period);
        $add->bindParam(5,$form);
        $add->bindParam(6,$fProgram);
        $add->bindParam(7,$fPlan);
        $add->bindParam(8,$fRehabilitation);
        $add->bindParam(9,$nozology);
        $add->bindParam(10,$universityId);
        $add->bindParam(11,$name);
        $add->bindParam(12, $studentId);
        $add->bindParam(13,$reason);
        $add->bindParam(14,$dateBegin);
        $add->bindParam(15,$dateEnd);
        $add->execute();
        $response = $add->fetchAll(PDO::FETCH_NUM);
        if (empty($response)){
            echo "OK";
        }
        else{
            echo $response[0][0];
        }
    }

    public function edit_student_change_program($studentId, $name, $nozology, $dateBegin, $dateEnd, $direction, $profile, $level, $period, $form, $fProgram, $fPlan, $fRehabilitation, $universityId, $programId){
        $conn = parent::get_db_connection();
        $add = $conn->prepare("CALL changeProgramActual(?,?,?,?,?,  ?,?,?,?,?,  ?,?,?,?,?)");
        $add->bindParam(1,$studentId);
        $add->bindParam(2,$name);
        $add->bindParam(3,$nozology);
        $add->bindParam(4,$programId);
        $add->bindParam(5,$direction);
        $add->bindParam(6,$profile);
        $add->bindParam(7,$level);
        $add->bindParam(8,$period);
        $add->bindParam(9,$universityId);
        $add->bindParam(10,$form);
        $add->bindParam(11,$fProgram);
        $add->bindParam(12, $fPlan);
        $add->bindParam(13,$fRehabilitation);
        $add->bindParam(14,$dateBegin);
        $add->bindParam(15,$dateEnd);
        $add->execute();
        $response = $add->fetchAll(PDO::FETCH_NUM);
        if (empty($response)){
            echo "OK";
        }
        else{
            echo $response[0][0];
        }
    }

    public function edit_student_switch_program($studentId, $name, $nozology, $dateBegin, $dateEnd, $programId, $reason){
        $conn = parent::get_db_connection();
        $add = $conn->prepare("CALL changeProgramExist(?,?,?,?,?,  ?,?)");
        $add->bindParam(1,$programId);
        $add->bindParam(2,$studentId);
        $add->bindParam(3,$reason);
        $add->bindParam(4,$dateBegin);
        $add->bindParam(5,$dateEnd);
        $add->bindParam(6,$name);
        $add->bindParam(7,$nozology);
        $add->execute();
        $response = $add->fetchAll(PDO::FETCH_NUM);
        if (empty($response)){
            echo "OK";
        }
        else{
            echo $response[0][0];
        }
    }

    public function edit_student_change_info($studentId, $name, $nozology, $dateBegin, $dateEnd){
        $conn = parent::get_db_connection();
        $add = $conn->prepare("CALL changeInfoStudent(?,?,?,?,?)");
        $add->bindParam(1,$name);
        $add->bindParam(2,$nozology);
        $add->bindParam(3,$dateBegin);
        $add->bindParam(4,$dateEnd);
        $add->bindParam(5,$studentId);
        $add->execute();
        $response = $add->fetchAll(PDO::FETCH_NUM);
        if (empty($response)){
            echo "OK";
        }
        else{
            echo $response[0][0];
        }
    }

    public function changeDebt($id, $status, $debts, $file) {
        $conn = parent::get_db_connection();
        $debts = explode(",", $debts);
        $query = '';
        if($status=='Задолженность') {
            foreach ($debts as $value) {
                $query = $query . "; CALL addBacklogDiscipline(?,?,?)";
            }
        }
        $change = $conn->prepare("CALL updateTrajectory(?,?,?)".$query);
        $change->bindParam(1, $status);
        $change->bindParam(2, $id);
        if($file) $file = $this->saveFile($file,"orders/");
        $change->bindParam(3, $file);
        if($status=='Задолженность') {
            $i = 4;
            foreach ($debts as $value) {
                $arr = explode(":", $value);
                $change->bindParam($i, $id);
                $i++;
                $change->bindParam($i, $arr[0]);
                $i++;
                $change->bindParam($i, $arr[1]);
                $i++;
            }
        }
        $change->execute();
        if(!$change->errorCode()[0]) {
            return "OK";
        }
        else return $change->errorInfo()[0];
    }

    public function add_debt($id) {
        $conn = parent::get_db_connection();
        $add = $conn->prepare("CALL addTrajectory(?)");
        $add->bindParam(1, $id);
        $add->execute();
        if($add->errorCode()[0])
            return $add->errorInfo()[0];
        else
            return "OK";
    }

    public function saveFile($file, $path) {
        $file = explode(",",$file);
        $decode = str_replace(' ','+',$file[1]);
        $pdf = base64_decode($decode);
        $name = time();
        $name = md5($name);
        $name = substr($name,0,10);
        $name = $name.".pdf";
        file_put_contents($path.$name, $pdf);
        return $name;
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