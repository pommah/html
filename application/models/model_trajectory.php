<?php
class Model_Trajectory extends Model
{
    public  function get_Trajectories($universityId) {
        $student = [];
        $conn = parent::get_db_connection();
        $req = $conn->prepare("SELECT Student.ID, Student.Name, Trajectory.Status, Trajectory.Note, NumberSemester, BacklogDiscipline.Name AS Discipline, Deadline 
          FROM (((Trajectory inner join LearningStudent on ID_Learning=LearningStudent.ID) inner join Student ON LearningStudent.ID_Student=Student.ID) 
          left join BacklogDiscipline on Trajectory.ID=BacklogDiscipline.ID_Semester) inner join ProgramStudent on ProgramStudent.ID = LearningStudent.ID_Program
          where ProgramStudent.ID_University = ? order by Student.ID ASC, NumberSemester ASC");
        $req->bindParam(1, $universityId);
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_NAMED);
        foreach ($data as $row){
            $id = $row['ID'];
            if (!array_key_exists($id, $student)){
                $student[$id] = ['Name' => $row['Name'],'Semesters'=>[] ];
            }
            $semester = $row['NumberSemester'];
            if (!array_key_exists($semester, $student[$id]['Semesters'])){
                $color = '#ffffff';
                switch ($row['Status']) {
                    case 'Активен':
                        $color = '#ccccb3';
                        break;
                    case 'Закончен':
                        $color = '#64DD17';
                        break;
                    case 'Задолженность':
                        $color = '#FFD600';
                        break;
                    case 'Отчислен': $color='#D50000'; break;
                }
                $student[$id]['Semesters'][$semester] = ['Status' => $row['Status'], 'Note' => $row['Note'], 'Color' => $color, 'Disciplines' => []];
            }
            if ($row['Discipline'] != null){
                array_push($student[$id]['Semesters'][$semester]['Disciplines'], ['Name' => $row['Discipline'], 'Deadline' => $row['Deadline']]);
            }
        }
        return $student;
    }
}