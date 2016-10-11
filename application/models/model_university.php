<?php
class Model_University extends Model
{
    public function get_region_names(){
        $req = parent::get_db_connection()->prepare("SELECT Name FROM Region");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_COLUMN, 0);
    }
}