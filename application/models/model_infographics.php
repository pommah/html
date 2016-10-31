<?php
Class Model_Infographics extends Model {
    public function get_statistic_region() {
        $req=parent::get_db_connection()->query("select q1.Code, q1.Name, allst, IFNULL(bad, 0) as bad
from (select Region.Code, Region.Name, count(LearningStudent.ID) as allst
	from Region left join University on University.ID_Region = Region.ID 
    left join ProgramStudent on ProgramStudent.ID_University = University.ID
    left join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID 
    Group by Region.Code, Region.Name) AS q1 left join (select Code, Name, count(*) as bad
    from (select Region.Code, Region.Name, LearningStudent.Id as learn
	from Region left join University on University.ID_Region = Region.ID 
    left join ProgramStudent on ProgramStudent.ID_University = University.ID
    left join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID 
    left join Trajectory on Trajectory.ID_Learning = LearningStudent.ID
    where Trajectory.Status = 'Задолженность'
    Group by Region.Code, Region.Name, LearningStudent.Id) t Group by Code, Name) AS q2 ON q1.Code = q2.Code");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }
}
?>