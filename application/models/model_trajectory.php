<?php
class Model_Trajectory extends Model
{
    public  function get_Trajectories() {
        $student = [];
        $conn = parent::get_db_connection();
        $req = $conn->query("SELECT Student.ID, Student.Name, Trajectory.Status, Trajectory.Note, NumberSemester, BacklogDiscipline.Name AS Discipline, Deadline 
          FROM (((Trajectory inner join LearningStudent on ID_Learning=LearningStudent.ID) inner join Student ON LearningStudent.ID_Student=Student.ID) 
          left join BacklogDiscipline on Trajectory.ID=BacklogDiscipline.ID_Semester) order by Student.ID ASC, NumberSemester ASC");
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
                        $color = '#66ff66';
                        break;
                    case 'Задолженность':
                        $color = '#ffff33';
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