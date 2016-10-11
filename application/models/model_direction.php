<?php
class Model_Direction extends Model
{
    public function get_direction() {
        $dir = [];
        $nowUgsn = null;
        $req = parent::get_db_connection()->query("SELECT UGSN.ID as ugsnId, UGSN.Name as ugsnName, Direction.ID as dirId, Direction.Name as dirName FROM UGSN INNER JOIN Direction ON UGSN.ID = Direction.ID_Ugsn");
        while ($row = $req->fetch()) {
            if(!$nowUgsn || $nowUgsn!=$row['ugsnId']) {
                $dir[$row['ugsnId']] = [
                    "ugsnName" => $row['ugsnName'],
                    "listDir" => [
                        $row['dirId'] => $row['dirName']
                    ]
                ];
                $nowUgsn = $row['ugsnId'];
            }
            else {
                $dir[$row['ugsnId']]['listDir'][$row['dirId']] = $row['dirName'];
            }
        }
        return $dir;
    }
    public function get_university_directions($universityId){
        $dir = [];
        $nowUgsn = null;
        $req = parent::get_db_connection()->prepare("SELECT UGSN.ID as ugsnId, UGSN.Name AS ugsnName, Direction.ID AS dirId, Direction.Name AS dirName
	FROM (Direction INNER JOIN UniversityDirection ON Direction.ID=UniversityDirection.ID_Direction) INNER JOIN UGSN ON Direction.ID_Ugsn=UGSN.ID
	WHERE UniversityDirection.ID_University=?");
        $req->bindParam(1, $universityId);
        $req->execute();
        while ($row = $req->fetch()) {
            if(!$nowUgsn || $nowUgsn!=$row['ugsnId']) {
                $dir[$row['ugsnId']] = [
                    "ugsnName" => $row['ugsnName'],
                    "listDir" => [
                        $row['dirId'] => $row['dirName']
                    ]
                ];
                $nowUgsn = $row['ugsnId'];
            }
            else {
                $dir[$row['ugsnId']]['listDir'][$row['dirId']] = $row['dirName'];
            }
        }
        return $dir;
    }
    public function get_university_directions_id($universityId){
        $dir = [];
        $nowUgsn = null;
        $req = parent::get_db_connection()->prepare("SELECT Direction.ID AS dirId
	FROM Direction INNER JOIN UniversityDirection ON Direction.ID=UniversityDirection.ID_Direction
	WHERE UniversityDirection.ID_University=?");
        $req->bindParam(1, $universityId);
        $req->execute();
        $dir = $req->fetchAll(PDO::FETCH_COLUMN, 0);
        return $dir;
    }
    public function update_directions($directions){
        $prepareTable = parent::get_db_connection()->prepare("DELETE FROM UniversityDirection WHERE ID_University = ?");
        //Todo Функция получения id университета
        $universityId = 1;
        $prepareTable->bindParam(1, $universityId);
        $prepareTable->execute();
        foreach ($directions as $direction){
            $query = parent::get_db_connection()->prepare("INSERT INTO UniversityDirection (UniversityDirection.ID_University, UniversityDirection.ID_Direction) VALUES (?, ?)");
            $query->bindParam(1, $universityId);
            $query->bindParam(2, $direction);
            $query->execute();
        }
        return "OK";
    }
}