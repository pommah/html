<?php
class Model_University extends Model
{
    public function get_region_names(){
        $req = parent::get_db_connection()->prepare("SELECT ID, Name FROM Region");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_university_info()
    {
        $req = parent::get_db_connection()->prepare("SELECT * FROM learn.University WHERE ID=?");
        $universityId = 1;
        $req->bindParam(1, $universityId);
        $req->execute();
        return $req->fetch(PDO::FETCH_NAMED);
    }

    public function update_university_data($shortName, $fullName, $status, $regionID, $universityId){
        $req = parent::get_db_connection()->prepare("UPDATE University SET University.ShortName=?, University.FullName=?, University.Status=?, University.ID_Region=? WHERE University.ID=?");
        $req->bindParam(1, $shortName);
        $req->bindParam(2, $fullName);
        $req->bindParam(3, $status);
        $req->bindParam(4, $regionID);
        $req->bindParam(5, $universityId);
        $req->execute();
        echo "OK";
    }

    public function get_universities($regionId){
        $req = parent::get_db_connection()->prepare("select University.ID, University.FullName,
    count(distinct ProgramStudent.ID) as Programs, 
    count(LearningStudent.ID_Program) as Students
	from Region left join University on University.ID_Region = Region.ID
    left join ProgramStudent on ProgramStudent.ID_University = University.ID
    left join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
    where Region.ID = ?
	group by University.ID, University.FullName");
        $req->bindParam(1, $regionId);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_districts(){
        $req = parent::get_db_connection()->query("select Okrug.ID, Okrug.Name, 
	count(distinct Region.ID) as Regions, 
    count(distinct ProgramStudent.ID) as Programs, 
    count(LearningStudent.ID_Program) as Students
	from Okrug inner join Region on Okrug.ID = Region.ID_Okrug
    left join University on University.ID_Region = Region.ID
    left join ProgramStudent on ProgramStudent.ID_University = University.ID
    left join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
	group by Okrug.ID, Okrug.Name");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }
    public function get_regions($districtId){
        $req = parent::get_db_connection()->prepare("select Region.ID, Region.Name, 
	count(distinct University.ID) as Univers, 
    count(distinct ProgramStudent.ID) as Programs, 
    count(LearningStudent.ID_Program) as Students
	from Okrug inner join Region on Region.ID_Okrug = Okrug.ID
    left join University on University.ID_Region = Region.ID
    left join ProgramStudent on ProgramStudent.ID_University = University.ID
    left join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
    where Okrug.ID = ?
	group by Region.ID, Region.Name");
        $req->bindParam(1, $districtId);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_all_regions(){
        $req = parent::get_db_connection()->query("select Okrug.Name as okrugName, Region.ID, Region.Name as regionName
	from Region inner join Okrug on Region.ID_Okrug = Okrug.ID
    order by Okrug.Name asc, Region.Name asc");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function add_university($fullName, $shortName, $region, $status){
        $req = parent::get_db_connection()->prepare("insert into University(FullName, ShortName, ID_Region, Status) values(?,?,?,?)");
        $req->bindParam(1, $fullName);
        $req->bindParam(2, $shortName);
        $req->bindParam(3, $region);
        $req->bindParam(4, $status);
        if($req->execute()){
            echo "OK";
        }
        else{
            echo $req->errorInfo()[2];
        }
    }
}