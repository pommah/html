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

    public function get_regions_by_nozology_group($distict){
        $req = parent::get_db_connection()->prepare("select id, name, nozology, sum(c) as count
	from (
     select Region.ID as id, Region.Name as name, ProgramStudent.ID_NozologyGroup as nozology, count(LearningStudent.Id) as c 
     from University inner join ProgramStudent on ProgramStudent.ID_University = University.ID
     inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
     inner join Region on Region.ID = University.ID_Region 
     inner join Okrug on Okrug.ID = Region.ID_Okrug
     where LearningStudent.Status = 'Активно' AND Okrug.ID = ?
     Group by Region.ID, Region.Name, ProgramStudent.ID_NozologyGroup
     union select Region.ID as id, Region.Name as name, NozologyGroup.ID as nozology, 0 as c 
     from Region cross join NozologyGroup
     inner join Okrug on Okrug.ID = Region.ID_Okrug
     where Okrug.ID = ?
    ) t
    Group by id, name, nozology");
        $req->bindParam(1, $distict);
        $req->bindParam(2, $distict);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_universities_by_nozology_group($region){
        $req = parent::get_db_connection()->prepare("select id, name, nozology, sum(c) as count
	from (
     select University.ID as id, University.FullName as name, ProgramStudent.ID_NozologyGroup as nozology, count(LearningStudent.Id) as c 
     from University inner join ProgramStudent on ProgramStudent.ID_University = University.ID
     inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
     inner join Region on Region.ID = University.ID_Region 
     inner join Okrug on Okrug.ID = Region.ID_Okrug
     where LearningStudent.Status = 'Активно' AND Region.ID = ?
     Group by University.ID, University.FullName, ProgramStudent.ID_NozologyGroup
     union select University.ID as id, University.FullName as name, NozologyGroup.ID as nozology, 0 as c 
     from University cross join NozologyGroup 
     inner join Region on University.ID_Region = Region.ID
     where Region.ID = ?
    ) t
    Group by id, name, nozology");
        $req->bindParam(1, $region);
        $req->bindParam(2, $region);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_districts_by_nozology_group(){
        $req = parent::get_db_connection()->query("select id, name, nozology, sum(c) as count
	from (
     select Okrug.ID as id, Okrug.Name as name, ProgramStudent.ID_NozologyGroup as nozology, count(LearningStudent.Id) as c 
     from University inner join ProgramStudent on ProgramStudent.ID_University = University.ID
     inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
     inner join Region on Region.ID = University.ID_Region 
     inner join Okrug on Okrug.ID = Region.ID_Okrug
     where LearningStudent.Status = 'Активно'
     Group by Okrug.ID, Okrug.Name, ProgramStudent.ID_NozologyGroup
     union select Okrug.ID as id, Okrug.Name as name, NozologyGroup.ID as nozology, 0 as c 
     from Okrug cross join NozologyGroup
    ) t
    Group by id, name, nozology");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_all_ugsn(){
        $req = parent::get_db_connection()->query("SELECT * from UGSN");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_regions_by_directions($district, $ugsn){
        $req = parent::get_db_connection()->prepare("select ID as arg, Name as rowName, concat(substr(ID_Direction, 1, 2), '.', substr(ID_Direction, 3, 2), '.', substr(ID_Direction, 5, 2), ' ',dirName) as colName, ID_Direction as arg2, sum(count) as count
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

    public function get_regions_lag_by_directions($district, $ugsn){
        $req = parent::get_db_connection()->prepare("select ID as arg, Name as rowName, concat(substr(ID_Direction, 1, 2), '.', substr(ID_Direction, 3, 2), '.', substr(ID_Direction, 5, 2), ' ',dirName) as colName, ID_Direction as arg2, sum(count) as count
	from (select Region.ID, Region.Name, ProgramStudent.ID_Direction, Direction.Name as dirName, Count(distinct LearningStudent.ID) as count
		from Region inner join University on Region.ID = University.ID_Region
        inner join ProgramStudent on University.ID = ProgramStudent.ID_University
        inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
        inner join Direction on ProgramStudent.ID_Direction = Direction.ID 
        inner join Trajectory on Trajectory.ID_Learning = LearningStudent.ID
        where Region.ID_Okrug = ? AND Direction.ID_Ugsn = ? AND Trajectory.Status = 'Задолженность'
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

    public function get_regions_expelled_by_directions($district, $ugsn){
        $req = parent::get_db_connection()->prepare("select ID as arg, Name as rowName, concat(substr(ID_Direction, 1, 2), '.', substr(ID_Direction, 3, 2), '.', substr(ID_Direction, 5, 2), ' ',dirName) as colName, ID_Direction as arg2, sum(count) as count
	from (select Region.ID, Region.Name, ProgramStudent.ID_Direction, Direction.Name as dirName, Count(distinct LearningStudent.ID) as count
		from Region inner join University on Region.ID = University.ID_Region
        inner join ProgramStudent on University.ID = ProgramStudent.ID_University
        inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
        inner join Direction on ProgramStudent.ID_Direction = Direction.ID 
        inner join Trajectory on Trajectory.ID_Learning = LearningStudent.ID
        where Region.ID_Okrug = ? AND Direction.ID_Ugsn = ? AND Trajectory.Status = 'Отчислен'
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
        $req = parent::get_db_connection()->query("select ID as arg2, concat(substr(ID, 1, 2), '.', substr(ID, 3, 2), '.', substr(ID, 5, 2), ' ',Name) as rowName, okrugId as arg, okrug as colName, sum(count) as count
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

    public function get_ugsn_lag_by_districts(){
        $req = parent::get_db_connection()->query("select ID as arg2, concat(substr(ID, 1, 2), '.', substr(ID, 3, 2), '.', substr(ID, 5, 2), ' ',Name) as rowName, okrugId as arg, okrug as colName, sum(count) as count
	from (
	select UGSN.ID, UGSN.Name, Okrug.ID as okrugId, Okrug.Name as okrug, Count(distinct LearningStudent.Id) as count
		from Region inner join University on Region.ID = University.ID_Region
        inner join ProgramStudent on University.ID = ProgramStudent.ID_University
        inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
        inner join Trajectory on Trajectory.ID_Learning = LearningStudent.ID
        inner join Direction on ProgramStudent.ID_Direction = Direction.ID
        inner join UGSN on Direction.ID_Ugsn = UGSN.ID 
        inner join Okrug on Okrug.Id = Region.ID_Okrug
        where Trajectory.Status = 'Задолженность'
		group by UGSN.ID, UGSN.Name, Okrug.ID, Okrug.Name
	union
	select UGSN.ID, UGSN.Name, Okrug.ID as okrugId, Okrug.Name as okrug, 0 as count
		from UGSN cross join Okrug ) t
    group by ID, Name, okrugId, okrug");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_ugsn_expelled_by_districts(){
        $req = parent::get_db_connection()->query("select ID as arg2, concat(substr(ID, 1, 2), '.', substr(ID, 3, 2), '.', substr(ID, 5, 2), ' ',Name) as rowName, okrugId as arg, okrug as colName, sum(count) as count
	from (
	select UGSN.ID, UGSN.Name, Okrug.ID as okrugId, Okrug.Name as okrug, Count(distinct LearningStudent.Id) as count
		from Region inner join University on Region.ID = University.ID_Region
        inner join ProgramStudent on University.ID = ProgramStudent.ID_University
        inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
        inner join Trajectory on Trajectory.ID_Learning = LearningStudent.ID
        inner join Direction on ProgramStudent.ID_Direction = Direction.ID
        inner join UGSN on Direction.ID_Ugsn = UGSN.ID 
        inner join Okrug on Okrug.Id = Region.ID_Okrug
        where Trajectory.Status = 'Отчислен'
		group by UGSN.ID, UGSN.Name, Okrug.ID, Okrug.Name
	union
	select UGSN.ID, UGSN.Name, Okrug.ID as okrugId, Okrug.Name as okrug, 0 as count
		from UGSN cross join Okrug ) t
    group by ID, Name, okrugId, okrug");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_universities_by_direction($region, $direction){
        $req = parent::get_db_connection()->prepare("select ID as arg, FullName as rowName, concat(substr(ID_Direction, 1, 2), '.', substr(ID_Direction, 3, 2), '.', substr(ID_Direction, 5, 2), ' ',dirName) as colName, sum(count) as count
	from (select University.ID, University.FullName, ProgramStudent.ID_Direction, Direction.Name as dirName, Count(*) as count
		from  University inner join ProgramStudent on University.ID = ProgramStudent.ID_University 
        inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
        inner join Direction on ProgramStudent.ID_Direction = Direction.ID 
        where University.ID_Region = ? AND ProgramStudent.ID_Direction = ? 
		group by University.ID, University.FullName, ProgramStudent.ID_Direction, Direction.Name
	union select University.ID, University.FullName, Direction.ID, Direction.Name as dirName, 0 as count
		from University cross join Direction 
        where University.ID_Region = ? AND Direction.ID = ?) t	
	group by ID, FullName, ID_Direction, dirName");
        $req->bindParam(1, $region);
        $req->bindParam(2, $direction);
        $req->bindParam(3, $region);
        $req->bindParam(4, $direction);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_universities_lag_by_direction($region, $direction){
        $req = parent::get_db_connection()->prepare("select ID as arg, FullName as rowName, concat(substr(ID_Direction, 1, 2), '.', substr(ID_Direction, 3, 2), '.', substr(ID_Direction, 5, 2), ' ',dirName) as colName, sum(count) as count
	from (select University.ID, University.FullName, ProgramStudent.ID_Direction, Direction.Name as dirName, Count(DISTINCT LearningStudent.ID) as count
		from  University inner join ProgramStudent on University.ID = ProgramStudent.ID_University 
        inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
        inner join Direction on ProgramStudent.ID_Direction = Direction.ID
        inner join Trajectory on Trajectory.ID_Learning = LearningStudent.ID
        where University.ID_Region = ? AND ProgramStudent.ID_Direction = ? AND Trajectory.Status = 'Задолженность' 
		group by University.ID, University.FullName, ProgramStudent.ID_Direction, Direction.Name
	union select University.ID, University.FullName, Direction.ID, Direction.Name as dirName, 0 as count
		from University cross join Direction 
        where University.ID_Region = ? AND Direction.ID = ?) t	
	group by ID, FullName, ID_Direction, dirName");
        $req->bindParam(1, $region);
        $req->bindParam(2, $direction);
        $req->bindParam(3, $region);
        $req->bindParam(4, $direction);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_universities_expelled_by_direction($region, $direction){
        $req = parent::get_db_connection()->prepare("select ID as arg, FullName as rowName, concat(substr(ID_Direction, 1, 2), '.', substr(ID_Direction, 3, 2), '.', substr(ID_Direction, 5, 2), ' ',dirName) as colName, sum(count) as count
	from (select University.ID, University.FullName, ProgramStudent.ID_Direction, Direction.Name as dirName, Count(DISTINCT LearningStudent.ID) as count
		from  University inner join ProgramStudent on University.ID = ProgramStudent.ID_University 
        inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
        inner join Direction on ProgramStudent.ID_Direction = Direction.ID
        inner join Trajectory on Trajectory.ID_Learning = LearningStudent.ID
        where University.ID_Region = ? AND ProgramStudent.ID_Direction = ? AND Trajectory.Status = 'Отчислен' 
		group by University.ID, University.FullName, ProgramStudent.ID_Direction, Direction.Name
	union select University.ID, University.FullName, Direction.ID, Direction.Name as dirName, 0 as count
		from University cross join Direction 
        where University.ID_Region = ? AND Direction.ID = ?) t	
	group by ID, FullName, ID_Direction, dirName");
        $req->bindParam(1, $region);
        $req->bindParam(2, $direction);
        $req->bindParam(3, $region);
        $req->bindParam(4, $direction);
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

    public function report_all_ugsn_district(){
        $req = parent::get_db_connection()->query("select  concat(substr(ID, 1, 2), '.', substr(ID, 3, 2), '.', substr(ID, 5, 2), ' ',Name) as rowName, okrug as colName, sum(count) as value
	from (
	select UGSN.ID, UGSN.Name, Okrug.ID as okrugId, Okrug.Name as okrug, Count(*) as count
		from (((((Region inner join University on Region.ID = University.ID_Region) inner join ProgramStudent on University.ID = ProgramStudent.ID_University) inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID) inner join Direction on ProgramStudent.ID_Direction = Direction.ID) inner join UGSN on Direction.ID_Ugsn = UGSN.ID) inner join Okrug on Okrug.Id = Region.ID_Okrug
		group by UGSN.ID, UGSN.Name, Okrug.ID, Okrug.Name
	union
	select UGSN.ID, UGSN.Name, Okrug.ID as okrugId, Okrug.Name as okrug, 0 as count
		from UGSN cross join Okrug ) t
    group by ID, Name, okrug");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function report_ugsn_district($status){
        $req = parent::get_db_connection()->prepare("select concat(substr(ID, 1, 2), '.', substr(ID, 3, 2), '.', substr(ID, 5, 2), ' ', Name) as rowName, okrug as colName, sum(count) as value
	from (
	select UGSN.ID, UGSN.Name, Okrug.ID as okrugId, Okrug.Name as okrug, Count(distinct LearningStudent.Id) as count
		from Region inner join University on Region.ID = University.ID_Region
        inner join ProgramStudent on University.ID = ProgramStudent.ID_University
        inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
        inner join Trajectory on Trajectory.ID_Learning = LearningStudent.ID
        inner join Direction on ProgramStudent.ID_Direction = Direction.ID
        inner join UGSN on Direction.ID_Ugsn = UGSN.ID 
        inner join Okrug on Okrug.Id = Region.ID_Okrug
        where Trajectory.Status = ?
		group by UGSN.ID, UGSN.Name, Okrug.ID, Okrug.Name
	union
	select UGSN.ID, UGSN.Name, Okrug.ID as okrugId, Okrug.Name as okrug, 0 as count
		from UGSN cross join Okrug ) t
    group by ID, Name, okrug");
        $req->bindParam(1, $status);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function report_direction_region($status){
        $req = parent::get_db_connection()->prepare("select Name as rowName, concat(substr(ID_Direction, 1, 2), '.', substr(ID_Direction, 3, 2), '.', substr(ID_Direction, 5, 2), ' ', dirName) as colName, sum(count) as value
	from (select Region.ID, Region.Name, ProgramStudent.ID_Direction, Direction.Name as dirName, Count(distinct LearningStudent.ID) as count
		from Region inner join University on Region.ID = University.ID_Region
        inner join ProgramStudent on University.ID = ProgramStudent.ID_University
        inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
        inner join Direction on ProgramStudent.ID_Direction = Direction.ID 
        inner join Trajectory on Trajectory.ID_Learning = LearningStudent.ID
        where Trajectory.Status = ?
		group by Region.ID, Region.Name, ProgramStudent.ID_Direction, Direction.Name
	union select Region.ID, Region.Name, Direction.ID, Direction.Name as dirName, 0 as count
		from Region cross join Direction) t	
	group by Name, ID_Direction, dirName");
        $req->bindParam(1, $status);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function report_all_direction_region(){
        $req = parent::get_db_connection()->query("select Name as rowName, concat(substr(ID_Direction, 1, 2), '.', substr(ID_Direction, 3, 2), '.', substr(ID_Direction, 5, 2), ' ', dirName) as colName, sum(count) as value
	from (select Region.ID, Region.Name, ProgramStudent.ID_Direction, Direction.Name as dirName, Count(distinct LearningStudent.ID) as count
		from Region inner join University on Region.ID = University.ID_Region
        inner join ProgramStudent on University.ID = ProgramStudent.ID_University
        inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
        inner join Direction on ProgramStudent.ID_Direction = Direction.ID
		group by Region.ID, Region.Name, ProgramStudent.ID_Direction, Direction.Name
	union select Region.ID, Region.Name, Direction.ID, Direction.Name as dirName, 0 as count
		from Region cross join Direction) t	
	group by Name, ID_Direction, dirName");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function report_region_nozology()
    {
        $req = parent::get_db_connection()->query("select name as rowName, nozology as colName, sum(c) as value
	from (
     select Region.Name as name, NozologyGroup.Name as nozology, count(LearningStudent.Id) as c 
     from University inner join ProgramStudent on ProgramStudent.ID_University = University.ID
     inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
     inner join Region on Region.ID = University.ID_Region
     inner join NozologyGroup on NozologyGroup.ID = ProgramStudent.ID_NozologyGroup
     Group by Region.Name, NozologyGroup.Name
     union select Region.Name as name, NozologyGroup.Name as nozology, 0 as c 
     from Region cross join NozologyGroup
    ) t
    Group by name, nozology");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function report_ugsn_nozology()
    {
        $req = parent::get_db_connection()->query("select ugsn as rowName, name as colName, sum(count) as value
	from (select concat(substr(UGSN.ID, 1, 2), '.', substr(UGSN.ID, 3, 2), '.', substr(UGSN.ID, 5, 2), ' ', UGSN.Name) as ugsn, NozologyGroup.Name as name, count(distinct LearningStudent.ID) as count
		from ProgramStudent inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
		inner join NozologyGroup on NozologyGroup.ID = ProgramStudent.ID_NozologyGroup
		inner join Direction on ProgramStudent.ID_Direction = Direction.ID
		inner join UGSN on UGSN.ID = Direction.ID_Ugsn
		group by UGSN.ID, UGSN.Name, NozologyGroup.Name
	union select concat(UGSN.ID, ' ', UGSN.Name) as ugsn, NozologyGroup.Name as name, 0 as count
		from UGSN cross join NozologyGroup
		group by UGSN.ID, UGSN.Name, NozologyGroup.Name) t
    group by ugsn, name");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }
}