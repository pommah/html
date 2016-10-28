<?php
Class Model_Infographics extends Model {
    public function get_statistic_region() {
        $req=parent::get_db_connection()->query("select q1.ID, q1.Name, allst, IFNULL(bad, 0) as bad
from (select Region.ID, Region.Name, count(LearningStudent.ID) as allst
	from Region left join University on University.ID_Region = Region.ID 
    left join ProgramStudent on ProgramStudent.ID_University = University.ID
    left join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID 
    Group by Region.ID, Region.Name) AS q1 left join (select ID, Name, count(*) as bad
    from (select Region.ID, Region.Name, LearningStudent.Id as learn
	from Region left join University on University.ID_Region = Region.ID 
    left join ProgramStudent on ProgramStudent.ID_University = University.ID
    left join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID 
    left join Trajectory on Trajectory.ID_Learning = LearningStudent.ID
    where Trajectory.Status = 'Задолженность'
    Group by Region.ID, Region.Name, LearningStudent.Id) t Group by ID, Name) AS q2 ON q1.ID = q2.ID");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }
}
?>