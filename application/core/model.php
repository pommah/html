<?php
class Model
{
    public static function get_db_connection(){
        include ('modules/db.php');
        try {
            return $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>