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

    public function get_universities(){
        $req = parent::get_db_connection()->query("SELECT University.ID, Region.Name, University.FullName, count(LearningStudent.ID) AS count
	from ((University inner join Region On University.ID_Region=Region.ID) inner join ProgramStudent ON University.ID = ProgramStudent.ID_University) inner join LearningStudent on LearningStudent.ID_Program = ProgramStudent.ID
    where LearningStudent.Status = \"Активно\"
	group by University.ID, Region.Name, University.FullName");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NAMED);
    }
}