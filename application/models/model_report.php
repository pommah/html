<?php
Class Model_Report extends Model {
    public function general_info() {

    }

    public function get_regions_by_nozology_group(){
        $req = parent::get_db_connection()->query("select name, nozology, sum(c) as count
	from (
     select Region.Name as name, ProgramStudent.ID_NozologyGroup as nozology, count(LearningStudent.Id) as c from ((University inner join ProgramStudent on ProgramStudent.ID_University = University.ID) Inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID) inner join Region on Region.ID = University.ID_Region where LearningStudent.Status = 'Активно' Group by Region.Name, ProgramStudent.ID_NozologyGroup
     union select Region.Name as name, NozologyGroup.ID as nozology, 0 as c from (Region cross join NozologyGroup)
    ) t
    Group by name, nozology");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_all_ugsn(){
        $req = parent::get_db_connection()->query("SELECT * from UGSN");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_regions_by_ugsn(){
        $req = parent::get_db_connection()->query("select Name, ID, sum(count) as count
	from (select Region.Name, UGSN.ID, Count(*) as count
		from ((((Region inner join University on Region.ID = University.ID_Region) inner join ProgramStudent on University.ID = ProgramStudent.ID_University) inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID) inner join Direction on ProgramStudent.ID_Direction = Direction.ID) inner join UGSN on Direction.ID_Ugsn = UGSN.ID
		group by Region.Name, UGSN.ID
	union select Region.Name, UGSN.ID, 0 as count
		from Region cross join UGSN) t
	group by Name, ID");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }
}