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
        $req = parent::get_db_connection()->prepare("SELECT University.ID, Region.Name, University.FullName, count(LearningStudent.ID) AS count
	from ((University inner join Region On University.ID_Region=Region.ID) left join ProgramStudent ON University.ID = ProgramStudent.ID_University) left join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
    where Region.ID = ?
	group by University.ID, Region.Name, University.FullName");
        $req->bindParam(1, $regionId);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }

    public function get_districts(){
        $req = parent::get_db_connection()->query("select Okrug.ID, Okrug.Name, count(Region.ID) as count
	from Okrug inner join Region on Okrug.ID = Region.ID_Okrug
    group  by Okrug.ID, Okrug.Name");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }
    public function get_regions($districtId){
        $req = parent::get_db_connection()->prepare("select Region.ID, Region.Name, count(University.ID) as count
	from (Region inner join University on Region.ID = University.ID_Region) inner join Okrug On Region.ID_Okrug = Okrug.ID
    where Okrug.ID = ?
    group by Region.ID, Region.Name");
        $req->bindParam(1, $districtId);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }
}