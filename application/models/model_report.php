<?php
Class Model_Report extends Model {
    public function general_info() {
        $conn = parent::get_db_connection();
        $req = $conn->query("SELECT (SELECT COUNT(*) FROM University) AS AllUniversity, (SELECT  COUNT(*) FROM University
        WHERE Status='Государственный') AS PublicUniversity, (SELECT COUNT(*) FROM University WHERE Status='Частный') AS PrivateUniversity,
        (SELECT COUNT(*) FROM Student) AS CountStudent, (SELECT COUNT(*) FROM Student WHERE ID_NozologyGroup=1) AS Vision,
        (SELECT COUNT(*) FROM Student WHERE ID_NozologyGroup=2) AS Hearing, (SELECT COUNT(*) FROM Student WHERE ID_NozologyGroup=3) AS MusculeSkelete");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
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

    public function get_regions_by_directions($district, $ugsn){
        $req = parent::get_db_connection()->prepare("select ID, Name, ID_Direction, dirName, sum(count) as count
	from (select Region.ID, Region.Name, ProgramStudent.ID_Direction, Direction.Name as dirName, Count(*) as count
		from ((((Region inner join University on Region.ID = University.ID_Region) inner join ProgramStudent on University.ID = ProgramStudent.ID_University) inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID) inner join Direction on ProgramStudent.ID_Direction = Direction.ID) where Region.ID_Okrug = ? AND Direction.ID_Ugsn = ? 
		group by Region.ID, Region.Name, ProgramStudent.ID_Direction, Direction.Name
	union select Region.ID, Region.Name, Direction.ID, Direction.Name as dirName, 0 as count
		from Region cross join Direction where Region.ID_Okrug = ? AND Direction.ID_Ugsn = ?) t	
	group by ID, Name, ID_Direction, dirName");
        $req->bindParam(1,$district);
        $req->bindParam(2,$ugsn);
        $req->bindParam(3,$district);
        $req->bindParam(4,$ugsn);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_ugsn_by_districts(){
        $req = parent::get_db_connection()->query("select ID, Name, okrugId, okrug, sum(count) as count
	from (
	select UGSN.ID, UGSN.Name, Okrug.ID as okrugId, Okrug.Name as okrug, Count(*) as count
		from (((((Region inner join University on Region.ID = University.ID_Region) inner join ProgramStudent on University.ID = ProgramStudent.ID_University) inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID) inner join Direction on ProgramStudent.ID_Direction = Direction.ID) inner join UGSN on Direction.ID_Ugsn = UGSN.ID) inner join Okrug on Okrug.Id = Region.ID_Okrug
		group by UGSN.ID, UGSN.Name, Okrug.ID, Okrug.Name
	union
	select UGSN.ID, UGSN.Name, Okrug.ID as okrugId, Okrug.Name as okrug, 0 as count
		from UGSN cross join Okrug ) t
    group by ID, Name, okrugId, okrug");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_stud_by_districts_for_pie(){
        $req = parent::get_db_connection()->query("select Okrug.Id, Okrug.Name, count(LearningStudent.ID) as count
	from Okrug left join Region on Okrug.ID = Region.ID_Okrug 
    left join University on University.ID_Region = Region.ID 
    left join ProgramStudent on ProgramStudent.ID_University = University.ID
    left join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
    group by Okrug.Id, Okrug.Name");
        $req->execute();
        $raw = $req->fetchAll(PDO::FETCH_NAMED);
        return $raw;
    }

    public function  get_stud_by_nozology_for_pie(){
        $req = parent::get_db_connection()->query("select Student.ID_NozologyGroup, NozologyGroup.Name, count(*) as count
	from LearningStudent inner join Student On LearningStudent.ID_Student = Student.ID 
    inner join NozologyGroup on Student.ID_NozologyGroup = NozologyGroup.ID
    Group by Student.ID_NozologyGroup, NozologyGroup.Name");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_stud_by_year_for_pie(){
        $req = parent::get_db_connection()->query("select year(DateBegin) as Name, count(*) as count
	from LearningStudent
    group by year(DateBegin)");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_stud_by_level_for_pie(){
        $req = parent::get_db_connection()->query("select ifnull(ProgramStudent.Level, 'Отсутствует') as Name, count(*) as count
	from LearningStudent inner join ProgramStudent On ProgramStudent.ID = LearningStudent.ID_Student
    group by ProgramStudent.Level");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_stud_by_form_for_pie(){
        $req = parent::get_db_connection()->query("select ifnull(ProgramStudent.Form, 'Отсутствует') as Name, count(*) as count
	from LearningStudent inner join ProgramStudent On ProgramStudent.ID = LearningStudent.ID_Student
    group by ProgramStudent.Form");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }
}