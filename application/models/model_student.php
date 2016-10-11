<?php
class Model_Student extends Model
{
    public function getStudents(){
        $list = [];
        $req = parent::get_db_connection()->prepare("SELECT Student.ID, Student.Name, NozologyGroup.Name AS \"NozologyGroup\" , Direction.Name 
          AS \"Direction\", ProgramStudent.NameFile
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
        $req = parent::get_db_connection()->prepare("SELECT Student.ID, Student.Name, NozologyGroup.Name AS \"NozologyGroup\" , Direction.Name 
          AS \"Direction\", ProgramStudent.NameFile, LearningStudent.DateBegin, LearningStudent.DateEnd, ProgramStudent.Level,
          ProgramStudent.Form
	      FROM (((Student INNER JOIN NozologyGroup ON Student.ID_NozologyGroup=NozologyGroup.ID) INNER JOIN 
	      LearningStudent ON LearningStudent.ID_Student=Student.ID ) INNER JOIN ProgramStudent ON ProgramStudent.ID =
	      LearningStudent.ID_Program) INNER JOIN Direction ON Direction.ID = ProgramStudent.ID_Direction
          WHERE Student.ID = ?");
        $req->bindParam(1,$id);
        $req->execute();
        if($req->rowCount()) {
            while ($row = $req->fetch()) {
                $student = [
                    "Name" => $row['Name'],
                    "Nozology" => $row['NozologyGroup'],
                    "Direction" => $row['Direction'],
                    "DateBegin" => $row['DateBegin'],
                    "DateEnd" => $row['DateEnd'],
                    "Level" => $row['Level'],
                    "Form" => $row['Form'],
                    "File" => $row['NameFile']
                ];
            }
        }
        else {
            $student = null;
        }
        return $student;
    }


}